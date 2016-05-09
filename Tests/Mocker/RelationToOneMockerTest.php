<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\EntityMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\RelationToOneMocker;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class FakeEntity2 {
    public function getId(){}
}

class RelationToOneMockerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityMocker
     */
    private $mocker;

    public function setUp() {
        $this->mocker = new RelationToOneMocker();
        $this->mocker->setAssociationAdmins(null);
        $this->mocker->setMappingType(null);
    }

    public function testGenerateWithThrowExceptionWithErrorMapping() {
        try {
            $this->mocker->setMappingValues([]);
            $this->mocker->generate();
        } catch(\Exception $e) {
            $this->assertInstanceOf(\Exception::class, $e);
            $this->assertEquals("The array mapping in relation mustn't be empty in RelationToOneMocker", $e->getMessage());
            return;
        }
        $this->fail("The array mapping in relation mustn't be empty");
    }

    public function testGenerateWithNoEntity()
    {
        try {
            $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
            $repo->expects($this->any())->method('findOneBy')->will($this->returnValue(null));

            $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
            $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
            $this->mocker->setEntityManager($em);
            $this->mocker->setMappingValues(['targetEntity' => FakeEntity2::class]);

            $data = $this->mocker->generate();
            $this->assertTrue(is_numeric($data));
            $this->assertEquals($data, 1);
        } catch (\Exception $e) {
            $this->assertInstanceOf(\Exception::class, $e);
            $this->assertEquals(sprintf("No found some Entity for class [%s]", FakeEntity2::class), $e->getMessage());
            return;
        }
    }

    public function testGenerate()
    {
        $entity = $this->getMockBuilder(FakeEntity2::class)->disableOriginalConstructor()->getMock();
        $entity->expects($this->any())->method('getId')->will($this->returnValue(1));

        $repo  = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
        $repo->expects($this->any())->method('findOneBy')->will($this->returnValue($entity));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repo));
        $this->mocker->setEntityManager($em);
        $this->mocker->setMappingValues(['targetEntity' => \std::class]);

        $data = $this->mocker->generate();
        $this->assertTrue(is_numeric($data));
        $this->assertEquals($data, 1);
    }
}
 