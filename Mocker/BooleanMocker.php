<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


use Sonata\AdminBundle\Admin\Admin;

class BooleanMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return sprintf('"%s"', ($this->faker->boolean() === true ? 1 : 0));
    }
}