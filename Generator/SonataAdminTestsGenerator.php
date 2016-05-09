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
    private $mockers;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var string
     */
    private $adminName;

	/**
	 * @param  Admin $admin
	 * @return false | int
	 */
	public function generate(Admin $admin)
	{
		$namespace = $this->getNamespace($admin);
        $data = $this->generateDatas($admin);

		return $this->renderFile('AdminTests.php.twig', $this->filePath, array(
			'admin' 		=> $admin,
			'formBuilder'   => $admin->getFormBuilder(),
            'listMapper'    => $admin->getList(),
			'admin_name' 	=> $this->adminName,
			'namespace' 	=> $namespace,
            'fakeData'      => $data
		));
	}

    protected function generateDatas(Admin $admin) {
        $_data = array();
        /**
         * @var string $name
         * @var FieldDescription $desc
         */
        foreach ($admin->getFormFieldDescriptions() as $name => $desc) {
            if (!isset($this->mockers[$desc->getType()])) {
                throw new \Exception(sprintf("The type [%s] is missing for %s", $desc->getType(), $name));
            }
            /** @var MockerInterface $mocker */
            $mocker = $this->mockers[$desc->getType()];
            $mocker->setAssociationAdmins($desc->getAssociationAdmin());
            $mocker->setMappingValues($desc->getAssociationMapping());
            $mocker->setMappingType($desc->getMappingType());
            $_data[$name] = $mocker->generate();
        }
        return $_data;
    }

    /**
     * @param array $mockers
     */
    public function setMockers(array $mockers)
    {
        $this->mockers = $mockers;
    }

	protected function getNamespace($admin)
	{
		$chunks = explode('\\', get_class($admin));
		$tmp = array_slice($chunks,0,count($chunks) - 2);
		$namespace = sprintf('%s\Tests', implode('\\', $tmp));
		return $namespace;
	}

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * @param string $adminName
     */
    public function setAdminName($adminName)
    {
        $this->adminName = $adminName;
    }
}