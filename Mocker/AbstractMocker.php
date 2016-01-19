<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Faker\Factory;
use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AbstractMocker implements MockerInterface
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var array
     */
    protected $mappingValues;

    /**
     * @var Admin
     */
    protected $associationAdmin;

    /**
     * @var  PropertyAccessorInterface
     */
    protected $accessor;

    /**
     * @var  FactoryMocker
     */
    protected $factoryMocker;

    /**
     * @var mixed
     */
    protected $mappingType;

    public function __construct() {
        $this->faker = Factory::create();
        $this->mappingValues = array();
        $this->associationAdmin = NULL;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @inheritdoc
     */
    public function generate() {
        throw new \Exception('You must create generate function');
    }

    /**
     * @inheritdoc
     */
    public function setMappingValues(array $mapping = null) {
        $this->mappingValues = $mapping;
    }

    /**
     * @inheritdoc
     */
    public function setAssociationAdmins(Admin $associationAdmin = null) {
        $this->associationAdmin = $associationAdmin;
    }

    /**
     * @inheritdoc
     */
    public function setFactoryMocker(FactoryMocker $factoryMocker = null) {
        $this->factoryMocker = $factoryMocker;
    }

    /**
     * @inheritdoc
     */
    public function setMappingType($mappingType = null) {
        $this->mappingType = $mappingType;
    }
}