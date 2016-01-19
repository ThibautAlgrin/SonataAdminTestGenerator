<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


use Sonata\AdminBundle\Admin\Admin;

class DateMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        return sprintf('"%s"', $this->faker->date("Y-m-d"));
    }
}