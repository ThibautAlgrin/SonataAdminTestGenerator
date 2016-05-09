<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;


use Algrin\SonataAdminTestGeneratorBundle\Fixtures\Entity\Article;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\MockerInterface;
use Algrin\SonataAdminTestsGeneratorBundle\Services\FactoryMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Tests\Fixtures\Admin\ArticleAdmin;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\RelationToManyMocker;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Controller\CRUDController;

class RelationToManyMockerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RelationToManyMocker
     */
    private $mocker;

    /**
     * @var AdminInterface
     */
    private $admin;

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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function buildCollectionAdmin() {
        $adminCollection = $this->getMock('Sonata\AdminBundle\Admin\AdminInterface');
        $adminCollection->expects($this->any())->method('getCode')->will($this->returnValue('foo'));
        $adminCollection->expects($this->any())->method('getClass')->will($this->returnValue('Acme\Entity\Foo'));
        $adminCollection->expects($this->any())->method('getBaseControllerName')->will($this->returnValue('SonataAdminBundle:CRUD'));
        $types = array();
        foreach ($this->_fields as $name => $_field) {
            $admin = $this->getMock('Sonata\AdminBundle\Admin\AdminInterface');
            $admin->expects($this->any())->method('getCode')->will($this->returnValue('foo'));
            $admin->expects($this->any())->method('getClass')->will($this->returnValue('Acme\Entity\Foo'));
            $admin->expects($this->any())->method('getBaseControllerName')->will($this->returnValue('SonataAdminBundle:CRUD'));


            $types[$name] = $this->getMock('Sonata\AdminBundle\Admin\FieldDescriptionInterface');
            $types[$name]->expects($this->any())->method('getType')->will($this->returnValue($_field));
            $types[$name]->expects($this->any())->method('getAssociationAdmin')->will($this->returnValue($admin));
            $types[$name]->expects($this->any())->method('getAssociationMapping')->will($this->returnValue(array()));

        }
        $adminCollection->expects($this->any())->method('getFormFieldDescriptions')->will($this->returnValue($types));
        return $adminCollection;
    }

    public function setUp() {

        foreach ($this->_fields as $fields) {
            $this->_fieldsMocker[$fields] = $this->getMock(MockerInterface::class);
            $this->_fieldsMocker[$fields]->expects($this->any())->method('generate')->will($this->returnValue('0'));
        }

        $fieldCollection = $this->getMock('Sonata\AdminBundle\Admin\FieldDescriptionInterface');
        $fieldCollection->expects($this->any())->method('getType')->will($this->returnValue('collection'));
        $fieldCollection->expects($this->any())->method('getAssociationAdmin')->will($this->returnValue($this->buildCollectionAdmin()));
        $fieldCollection->expects($this->any())->method('getAssociationMapping')->will($this->returnValue($this->_fields));

        $this->admin = $this->getMock('Sonata\AdminBundle\Admin\AdminInterface');
        $this->admin->expects($this->any())->method('getCode')->will($this->returnValue('foo'));
        $this->admin->expects($this->any())->method('getClass')->will($this->returnValue('Acme\Entity\Foo'));
        $this->admin->expects($this->any())->method('getBaseControllerName')->will($this->returnValue('SonataAdminBundle:CRUD'));
        $this->admin->expects($this->any())->method('getFormFieldDescriptions')->will($this->returnValue(array(
            'tags' => $fieldCollection
        )));
        $fields = $this->admin->getFormFieldDescriptions();

        $factoryMocker = $this->getMock(FactoryMocker::class);
        $factoryMocker->expects($this->any())->method('getMockers')->will($this->returnValue($this->_fieldsMocker));

        $this->mocker = new RelationToManyMocker();
        $this->mocker->setAssociationAdmins($fields['tags']->getAssociationAdmin());
        $this->mocker->setMappingValues($fields['tags']->getAssociationMapping());
        $this->mocker->setMappingType($fields['tags']->getMappingType());
        $this->mocker->setFactoryMocker($factoryMocker);
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

    public function testGenerateWithThrowExceptionWithAssociationAdmin() {
        try {
            $this->mocker->setAssociationAdmins(null);
            $this->mocker->generate();
        } catch(\Exception $e) {
            $this->assertInstanceOf(\Exception::class, $e);
            $this->assertEquals("The associationAdmin mustn't be null", $e->getMessage());
            return;
        }
        $this->fail("The associationAdmin mustn't be null");
    }


    public function testGenerate()
    {
        $data = $this->mocker->generate();
        $this->assertTrue(is_string($data));
        $this->assertNotEmpty($data);
        $this->assertNotFalse(strstr($data, "json_decode"));
        foreach (array_keys($this->_fields) as $field) {
            $this->assertNotFalse(strstr($data, $field));
        }
    }
}
 