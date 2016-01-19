<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class NumberMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return $this->faker->numberBetween();
    }
}