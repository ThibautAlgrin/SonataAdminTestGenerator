<?php

namespace Algrin\SonataAdminTestsGeneratorBundle;

use Algrin\SonataAdminTestsGeneratorBundle\DependencyInjection\Compiler\AddMockerTypeCompiler;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class AlgrinSonataAdminTestsGeneratorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddMockerTypeCompiler());
    }
}
