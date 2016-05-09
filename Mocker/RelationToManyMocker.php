<?php


namespace Algrin\SonataAdminTestsGeneratorBundle\Mocker;

class RelationToManyMocker extends AbstractMocker
{
    /**
     * @inheritdoc
     */
    public function generate() {
        if (empty($this->mappingValues)) {
            throw new \Exception("The array mapping in relation mustn't be empty");
        }
        if ($this->associationAdmin == NULL) {
            throw new \Exception("The associationAdmin mustn't be null");
        }
        $_data = array();
        $mockers = $this->factoryMocker->getMockers();
        $itemForm = $this->associationAdmin->getFormFieldDescriptions();
        /**
         * @var string $key
         * @var \Sonata\DoctrineORMAdminBundle\Admin\FieldDescription $item
         */
        foreach ($itemForm as $key => $item) {
            /** @var MockerInterface $mocker */
            $mocker = $mockers[$item->getType()];
            $mocker->setAssociationAdmins($item->getAssociationAdmin());
            $mocker->setMappingValues($item->getAssociationMapping());
            $mocker->setMappingType($item->getMappingType());
            $_data[$key] = $mocker->generate();
        }
        return sprintf("json_decode('%s', true)", json_encode(array($_data)));
    }
}