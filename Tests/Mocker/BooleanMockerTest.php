<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;


use Algrin\SonataAdminTestsGeneratorBundle\Mocker\BooleanMocker;

class BooleanMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate() {
        $mocker = new BooleanMocker();
        $value = $mocker->generate();
        $this->assertTrue($value === '"1"' || $value === '"0"');
    }
}
 