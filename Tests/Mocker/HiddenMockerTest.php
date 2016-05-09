<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\BooleanMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\EntityMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Mocker\HiddenMocker;
use Algrin\SonataAdminTestsGeneratorBundle\Services\FactoryMocker;
use Faker\Factory;

class HiddenMockerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EntityMocker
     */
    private $mocker;

    public function setUp() {
        $this->mocker = new HiddenMocker();
        $this->mocker->setMappingType("boolean");
        $value = Factory::create();
        $mocker = $this->getMock(BooleanMocker::class);
        $mocker->expects($this->any())->method('generate')->will($this->returnValue($value->boolean()));
        $factoryMocker = $this->getMock(FactoryMocker::class);
        $factoryMocker->expects($this->any())->method('getMockers')->will($this->returnValue(["boolean" => $mocker]));
        $this->mocker->setFactoryMocker($factoryMocker);
    }

    public function testGenerate() {
        $value = $this->mocker->generate();
        $this->assertTrue($value === true || $value === false);
    }
}
 