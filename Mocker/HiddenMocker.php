<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sonata\AdminBundle\Admin\Admin;

class HiddenMocker extends  AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        /** @var MockerInterface[] $mockers */
        $mockers = $this->factoryMocker->getMockers();
        return $mockers[$this->mappingType]->generate();
    }
}