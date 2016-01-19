<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class StringMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return sprintf('"%s"', implode(" ", $this->faker->words()));
    }
}