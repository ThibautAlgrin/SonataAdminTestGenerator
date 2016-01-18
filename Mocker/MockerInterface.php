<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;


interface MockerInterface
{
    /**
     * @param array $mapping
     * @return mixed
     */
    public function generate(array $mapping = []);
}