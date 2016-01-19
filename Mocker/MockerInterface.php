<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


use Sonata\AdminBundle\Admin\Admin;

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
     * @param Admin $associationAdmin
     */
    public function setAssociationAdmins(Admin $associationAdmin = null);

    /**
     * @param FactoryMocker $factoryMocker
     */
    public function setFactoryMocker(FactoryMocker $factoryMocker = null);

    /**
     * @param mixed $mappingType
     */
    public function setMappingType($mappingType = null);
}