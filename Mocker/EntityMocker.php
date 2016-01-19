<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Sonata\AdminBundle\Admin\Admin;

class EntityMocker extends  AbstractMocker
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @inheritdoc
     */
    public function generate() {
        if (empty($this->mapping)) {
            throw new \Exception("The array mapping in relation mustn't be empty");
        }
        if ($this->mapping['type'] == ClassMetadataInfo::ONE_TO_ONE || $this->mapping['type'] == ClassMetadataInfo::MANY_TO_ONE) {
            $entity = $this->em->getRepository($this->mapping['targetEntity'])->findOneBy([]);
            return $entity->getId();
        }
        else {
            $entity = $this->em->getRepository($this->mapping['targetEntity'])->findBy([], null, 5);
            $entities = array();
            foreach ($entity as $e) {
                $entities[] = $e->getId();
            }
            return $entities;
        }
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }
}