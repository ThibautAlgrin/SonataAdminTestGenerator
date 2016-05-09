<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Sonata\AdminBundle\Admin\Admin;

class JsonArrayMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        $array = [];
        for ($i = 0; $i < 10; $i++) {
            $array[] = $this->faker->word(20);
        }
        return sprintf("json_decode('%s', true)", json_encode($array));
    }
}