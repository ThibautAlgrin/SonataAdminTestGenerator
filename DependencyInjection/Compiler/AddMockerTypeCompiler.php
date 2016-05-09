<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddMockerTypeCompiler implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container) {
        $items = $container->findTaggedServiceIds('sonata_admin_tests_generator');
        foreach ($items as $id => $item) {
            foreach ($item as $value) {
                if (isset($value['key'])) {
                    $container
                        ->getDefinition('algrin_sonata_admin_tests_generator.services.factory')
                        ->addMethodCall('addMocker', array($value['key'], $container->getDefinition($id)));
                }
            }
        }
    }
}