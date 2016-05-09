<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Tests\Mocker;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\DateMocker;

class DateMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate() {
        $mocker = new DateMocker();
        $value = $mocker->generate();
        $this->assertEquals(preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $value), 1);
    }
}
 