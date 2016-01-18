<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Algrin\SonataAdminTestsGeneratorBundle\Generator\SonataAdminTestsGenerator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class GenerateCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private $skeletonDirectory;

    public function __construct($name = null) {
        parent::__construct($name);
        $this->skeletonDirectory = __DIR__ . '/../Resources/skeleton';
    }

    protected function configure()
    {
        $this->setName('algrin:admin:generate-tests');
        $this->setDescription('tests');
        $this->addArgument('admin_code', InputArgument::REQUIRED, 'Admin Code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $admin_code = $input->getArgument('admin_code');
        $admin 	= $this->getContainer()->get($admin_code);
        $bundleName = $this->getBundleNameFromClass($admin->getClass());
        $bundle = $this->getBundle($bundleName);
        $generator = new SonataAdminTestsGenerator();
        /** @var \Algrin\SonataAdminTestsGeneratorBundle\Mocker\FactoryMocker $factoryMocker */
        $factoryMocker = $this->getContainer()->get('algrin_sonata_admin_tests_generator.factory_mocker');
        $generator->setMockerFactory($factoryMocker->getMockers());
        $generator->setSkeletonDirs($this->skeletonDirectory);
        $generator->generate($admin, $bundle);
    }

    /**
     * @param string $name
     *
     * @return BundleInterface
     */
    protected function getBundle($name)
    {
        return $this->getApplication()->getKernel()->getBundle($name);
    }

    /**
     * @see Sonata\AdminBundle\Command\GenerateAdminCommand
     * @param string $class
     *
     * @return string|null
     *
     * @throws \InvalidArgumentException
     */
    private function getBundleNameFromClass($class)
    {
        $application = $this->getApplication();

        foreach ($application->getKernel()->getBundles() as $bundle) {
            if (strpos($class, $bundle->getNamespace() . '\\') === 0) {
                return $bundle->getName();
            };
        }
        return null;
    }
}