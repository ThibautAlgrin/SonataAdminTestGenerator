<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\NumberMocker;

class NumberMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate() {
        $mocker = new NumberMocker();
        $value = $mocker->generate();
        $this->assertTrue(is_numeric($value));
    }
}
 