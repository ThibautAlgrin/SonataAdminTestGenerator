<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\StringMocker;

class StringMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate() {
        $mocker = new StringMocker();
        $value = $mocker->generate();
        $this->assertTrue(is_string($value));
        $this->assertLessThanOrEqual(255, strlen($value));
    }
}
 