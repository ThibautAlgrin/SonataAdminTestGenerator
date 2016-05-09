<?php

namespace SonataAdminTestGeneratorBundle\Tests\Services;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\MockerInterface;
use Algrin\SonataAdminTestsGeneratorBundle\Services\FactoryMocker;

class FactoryMockerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddMocker() {
        $factoryMocker = new FactoryMocker();
        for ($i = 0; $i < 5; $i++) {
            /** @var MockerInterface $mocker */
            $mocker = $this->getMock(MockerInterface::class);
            $factoryMocker->addMocker(sprintf('test%d', $i), $mocker);
        }
        $mockers = $factoryMocker->getMockers();
        $this->assertCount(5, $mockers);
    }
}
