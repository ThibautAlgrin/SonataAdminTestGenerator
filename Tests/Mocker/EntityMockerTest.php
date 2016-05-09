<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\EntityMocker;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class FakeEntity {
    public function getId(){}
}

class EntityMockerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityMocker
     */
    private $mocker;

    /**
     * @var array
     */
    private $_fields = [
        'title' => 'string',
        'enabled' => 'boolean'
    ];

    /**
     * @var array
     */
    private $_fieldsMocker = [];

    public function setUp() {
        $this->mocker = new EntityMocker();
        $this->mocker->setAssociationAdmins(null);
        $this->mocker->setMappingType(null);
    }

    public function testGenerateWithThrowExceptionWithErrorMapping() {
        try {
            $this->mocker->setMappingValues([]);
            $this->mocker->generate();
        } catch(\Exception $e) {
            $this->assertInstanceOf(\Exception::class, $e);
            $this->assertEquals("The array mapping in relation mustn't be empty", $e->getMessage());
            return;
        }
        $this->fail("The array mapping in relation mustn't be empty");
    }

    public function testGenerateWithOneToOneRelation()
    {
        $entity = $this->getMockBuilder(FakeEntity::class)->disableOriginalConstructor()->getMock();
        $entity->expects($this->any())->method('getId')->will($this->returnValue(1));

        $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
        $repo->expects($this->any())->method('findOneBy')->will($this->returnValue($entity));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
        $this->mocker->setEntityManager($em);
        $this->mocker->setMappingValues(['targetEntity' => \std::class, 'type' => ClassMetadataInfo::ONE_TO_ONE]);

        $data = $this->mocker->generate();
        $this->assertTrue(is_numeric($data));
        $this->assertEquals($data, 1);
    }

    public function testGenerateWithManyToOneRelation()
    {
        $entity = $this->getMockBuilder(FakeEntity::class)->disableOriginalConstructor()->getMock();
        $entity->expects($this->any())->method('getId')->will($this->returnValue(1));

        $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
        $repo->expects($this->any())->method('findOneBy')->will($this->returnValue($entity));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
        $this->mocker->setEntityManager($em);
        $this->mocker->setMappingValues(['targetEntity' => \std::class, 'type' => ClassMetadataInfo::MANY_TO_ONE]);

        $data = $this->mocker->generate();
        $this->assertTrue(is_numeric($data));
        $this->assertEquals($data, 1);
    }

    public function testGenerateWithOneToManyRelation()
    {
        $entities = [];
        for ($i = 1; $i <= 5; $i++) {
            $entities[$i] = $this->getMockBuilder(FakeEntity::class)->disableOriginalConstructor()->getMock();
            $entities[$i]->expects($this->any())->method('getId')->will($this->returnValue($i));
        }

        $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
        $repo->expects($this->any())->method('findBy')->will($this->returnValue($entities));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
        $this->mocker->setEntityManager($em);
        $this->mocker->setMappingValues(['targetEntity' => \std::class, 'type' => ClassMetadataInfo::ONE_TO_MANY]);

        $data = $this->mocker->generate();
        $this->assertTrue(is_array($data));
        foreach ($data as $item) {
            $this->assertTrue(is_numeric($item));
        }
    }

    public function testGenerateWithManyToManyRelation()
    {
        $entities = [];
        for ($i = 1; $i <= 5; $i++) {
            $entities[$i] = $this->getMockBuilder(FakeEntity::class)->disableOriginalConstructor()->getMock();
            $entities[$i]->expects($this->any())->method('getId')->will($this->returnValue($i));
        }

        $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
        $repo->expects($this->any())->method('findBy')->will($this->returnValue($entities));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
        $this->mocker->setEntityManager($em);
        $this->mocker->setMappingValues(['targetEntity' => \std::class, 'type' => ClassMetadataInfo::MANY_TO_MANY]);

        $data = $this->mocker->generate();
        $this->assertTrue(is_array($data));
        foreach ($data as $item) {
            $this->assertTrue(is_numeric($item));
        }
    }
}
 