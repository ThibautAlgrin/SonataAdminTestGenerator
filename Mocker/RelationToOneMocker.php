<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

use Doctrine\ORM\EntityManager;

class RelationToOneMocker extends AbstractMocker
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @inheritdoc
     */
    public function generate() {
        if (empty($this->mappingValues)) {
            throw new \Exception("The array mapping in relation mustn't be empty in RelationToOneMocker");
        }
        $entity = $this->em->getRepository($this->mappingValues['targetEntity'])->findOneBy([]);
        if ($entity == NULL) {
            throw new \Exception("No found some Entity for class [%s]", $this->mappingValues['targetEntity']);
        }
        return $entity->getId();
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }
}