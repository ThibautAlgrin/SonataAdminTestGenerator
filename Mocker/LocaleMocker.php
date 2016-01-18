<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class LocaleMocker extends AbstractMocker
{
    /**
     * @param array $mapping
     * @return string
     */
    public function generate(array $mapping = []) {
        return $this->faker->locale;
    }
}