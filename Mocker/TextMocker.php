<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


class TextMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return sprintf('"%s"', implode(" ", $this->faker->words(100)));
    }
}