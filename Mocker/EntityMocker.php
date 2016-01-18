<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class EntityMocker implements MockerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param array $mapping
     * @return mixed
     * @throws \Exception is $mapping is empty
     */
    public function generate(array $mapping = []) {
        if (empty($mapping)) {
            throw new \Exception("The array mapping in relation mustn't be empty");
        }
        if ($mapping['type'] == ClassMetadataInfo::ONE_TO_ONE || $mapping['type'] == ClassMetadataInfo::MANY_TO_ONE) {
            $entity = $this->em->getRepository($mapping['targetEntity'])->findOneBy([]);
            return $entity->getId();
        }
        else {
            $entity = $this->em->getRepository($mapping['targetEntity'])->findBy([], null, 5);
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