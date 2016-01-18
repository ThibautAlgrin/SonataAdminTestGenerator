<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class BooleanMocker extends AbstractMocker
{
    /**
     * @param array $mapping
     * @return boolean
     */
    public function generate(array $mapping = []) {
        return ($this->faker->boolean() === true) ? 0 : 1;
    }
}