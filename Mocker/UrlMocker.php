<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


use Sonata\AdminBundle\Admin\Admin;

class UrlMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return sprintf('"%s"', $this->faker->url);
    }
}