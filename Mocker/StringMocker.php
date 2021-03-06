<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class StringMocker extends AbstractMocker
{
    /**
     * @param array $mapping
     * @return string
     */
    public function generate(array $mapping = []) {
        return implode(" ", $this->faker->words());
    }
}