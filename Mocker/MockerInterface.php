<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


use Algrin\SonataAdminTestsGeneratorBundle\Services\FactoryMocker;
use Sonata\AdminBundle\Admin\AdminInterface;

interface MockerInterface
{
    /**
     * @return mixed
     */
    public function generate();

    /**
     * @param array $mapping
     */
    public function setMappingValues(array $mapping);

    /**
     * @param AdminInterface $associationAdmin
     */
    public function setAssociationAdmins(AdminInterface $associationAdmin = null);

    /**
     * @param FactoryMocker $factoryMocker
     */
    public function setFactoryMocker(FactoryMocker $factoryMocker = null);

    /**
     * @param mixed $mappingType
     */
    public function setMappingType($mappingType = null);
}