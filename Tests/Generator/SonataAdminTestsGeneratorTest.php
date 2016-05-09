<?php

namespace SonataAdminTestGeneratorBundle\Tests\Generator;

use Algrin\SonataAdminTestsGeneratorBundle\Generator\SonataAdminTestsGenerator;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\BooleanMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\StringMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\TextMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Services\FactoryMocker;
use Sonata\AdminBundle\Admin\Admin;
use Faker\Factory;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;

class SonataAdminTestsGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Admin
     */
    private $admin;

    /**
     * @var array
     */
    private $mockerFactory;

    private function setFormFields() {
        $tmp = [
            'title' => 'string',
            'enabled' => 'boolean',
            'content' => 'text'
        ];
        $formFields = [];
        foreach ($tmp as $name => $type) {
            $mocker = $this->getMock(FieldDescriptionInterface::class);
            $mocker->expects($this->any())->method('getType')->will($this->returnValue($type));
            $mocker->expects($this->any())->method('getAssociationAdmin')->will($this->returnValue(NULL));
            $mocker->expects($this->any())->method('getAssociationMapping')->will($this->returnValue(NULL));
            $mocker->expects($this->any())->method('getMappingType')->will($this->returnValue(NULL));
            $formFields[$name] = $mocker;
        }
        $this->admin->expects($this->any())->method('getFormFieldDescriptions')->will($this->returnValue($formFields));
    }

    private function setAdmin() {
        $this->admin = $this->getMockBuilder(Admin::class)->disableOriginalConstructor()->getMock();
        $this->admin->expects($this->any())->method('getClass')->will($this->returnValue('TestAdmin'));
    }

    private function setFactoryMocker() {
        $faker = Factory::create();
        $this->mockerFactory = [];
        $tmp = [
            'title' => [
                'class' => StringMocker::class,
                'type' => 'string',
                'value' => $faker->words()
            ],
            'enabled' => [
                'class' => BooleanMocker::class,
                'type' => 'boolean',
                'value' => $faker->boolean()
            ],
            'content' => [
                'class' => TextMocker::class,
                'type' => 'text',
                'value' => $faker->words(200)
            ]
        ];
        foreach ($tmp as $type) {
            $mocker = $this->getMockBuilder($type['class'])->setMethods([
                'setAssociationAdmins',
                'setMappingValues',
                'setMappingType'
            ])->getMock();
            $mocker->expects($this->any())->method('generate')->will($this->returnValue($type['value']));
            $this->mockerFactory[$type['type']] = $mocker;
        }
    }

    public function setUp() {
        $this->setAdmin();
        $this->setFormFields();
        $this->setFactoryMocker();
    }

    public function testGenerateWithEmptyMockerFactory()
    {
        try {
            $generator = new SonataAdminTestsGenerator();
            $generator->setSkeletonDirs(realpath(__FILE__.'../../skeleton/'));
            $generator->setFilePath(realpath(__FILE__));
            $generator->setClass($this->admin);
            $generator->setAdminName("Test");
            $generator->generate($this->admin);
            $generator->setMockerFactory([]);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), "The type [string] is missing for title");
            return;
        }
        $this->fail("The test testGenerateWithEmptyMockerFactory must throw Exception");
    }

    public function testGenerate()
    {
        $generator = new SonataAdminTestsGenerator();
        $generator->setFilePath('.');
        $generator->setClass($this->admin);
        $generator->setAdminName("Test");
        $generator->setMockerFactory($this->mockerFactory);
        $generator->generate($this->admin);
    }
}
 