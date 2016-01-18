<?php

namespace Algrin\SonataAdminTestsGeneratorBundle\Generator;

use Algrin\SonataAdminTestsGeneratorBundle\Mocker\MockerInterface;
use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Sonata\AdminBundle\Admin\Admin;

class SonataAdminTestsGenerator extends Generator
{
    /**
     * @var array
     */
    private $mockerFactory;

	/**
	 * @param  Admin $admin
	 * @param  BundleInterface $bundle
	 * @return false | int
	 */
	public function generate(Admin $admin, BundleInterface $bundle)
	{
		$admin_name = substr(get_class($admin), strripos(get_class($admin), '\\') + 1);
		$filePath = sprintf('%s/Tests/Admin/%sTest.php',$bundle->getPath(), $admin_name);
        $class = $admin->getClass();
        $mock = new $class();
        $admin->setSubject($mock);
		$namespace = $this->getNamespace($admin);
        $data = $this->generateDatas($admin->getFormFieldDescriptions());
		return $this->renderFile('AdminTests.php.twig', $filePath, array(
			'admin' 		=> $admin,
			'formBuilder'  => $admin->getFormBuilder(),
            'listMapper'  => $admin->getList(),
			'admin_name' 	=> $admin_name,
			'namespace' 	=> $namespace,
            'fakeData'      => $data
		));
	}

    protected function generateDatas(array $formField) {
        $_data = array();
        /**
         * @var string $name
         * @var FieldDescription $desc
         */
        foreach ($formField as $name => $desc) {
            if (!isset($this->mockerFactory[$desc->getType()])) {
                throw new \Exception(sprintf("The type [%s] is missing", $desc->getType()));
            }
            /** @var MockerInterface $mocker */
            $mocker = $this->mockerFactory[$desc->getType()];
            // It is a relation
            if ($desc->getAssociationMapping() != NULL) {
                $_data[$name] = $mocker->generate($desc->getAssociationMapping());
            } else {
                $_data[$name] = $mocker->generate();
            }
        }
        return $_data;
    }

    /**
     * @param array $mockerFactory
     */
    public function setMockerFactory(array $mockerFactory)
    {
        $this->mockerFactory = $mockerFactory;
    }

	protected function getNamespace($admin)
	{
		$chunks = explode('\\', get_class($admin));
		$tmp = array_slice($chunks,0,count($chunks) - 2);
		$namespace = sprintf('%s\Tests', implode('\\', $tmp));
		return $namespace;
	}

}