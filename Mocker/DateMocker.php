<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class DateMocker extends AbstractMocker
{
    /**
     * @param array $mapping
     * @return boolean
     */
    public function generate(array $mapping = []) {
        return $this->faker->date("Y-m-d");
    }
}