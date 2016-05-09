<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\TextMocker;

class TextMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate() {
        $mocker = new TextMocker();
        $value = $mocker->generate();
        $this->assertTrue(is_string($value));
        $this->assertGreaterThanOrEqual(255, strlen($value));
    }
}
 