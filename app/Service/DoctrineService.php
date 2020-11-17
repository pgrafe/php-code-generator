<?php


namespace PGrafe\PhpCodeGenerator\Service;

use PGrafe\PhpCodeGenerator\Builder\ClassBuilder;
use PGrafe\PhpCodeGenerator\Enum\BuildState;
use PGrafe\PhpCodeGenerator\Enum\DoctrineType;
use PGrafe\PhpCodeGenerator\Enum\PhpType;
use PGrafe\PhpCodeGenerator\Model\DoctrineBuildModel;
use DateTime;
use DOMElement;


class DoctrineService
{

    /**
     * @param string $path
     * @param array $ignoreNamespacePathList
     * @param array $addPathList
     * @return DoctrineBuildModel[]
     */
    public function getDoctrineBuildModelList(string $path, array $ignoreNamespacePathList, array $addPathList): array
    {
        $doctrineBuildModelList = [];
        $xmlFileService         = new XmlFileService();
        $domDocumentList        = $xmlFileService->getDoctrineDomDocumentList($path);
        if (count($domDocumentList) === 0) {
            $doctrineBuildModel = new DoctrineBuildModel();
            $doctrineBuildModel->addMessage('could not find any XML file beneath: ' . $path);
            $doctrineBuildModel->setState(BuildState::NO_XML_FOUND());
            $doctrineBuildModelList[] = $doctrineBuildModel;

            return $doctrineBuildModelList;
        }
        foreach ($domDocumentList as $DOMDocument) {
            foreach ($DOMDocument->getElementsByTagName('entity') as $DOMNode) {
                $doctrineBuildModel = new DoctrineBuildModel();
                if (!$DOMNode instanceof DOMElement) {
                    $doctrineBuildModel->addMessage('could not find valid DOMElement');
                    $doctrineBuildModelList[] = $doctrineBuildModel;
                    $doctrineBuildModel->setState(BuildState::BUILD_FAILED());

                    continue;
                }
                $entityFQCN      = $DOMNode->getAttribute('name');
                $entityFQCNList  = explode('\\', $entityFQCN);
                $entityName      = array_pop($entityFQCNList);
                $entityNameSpace = implode('\\', $entityFQCNList);
                $entityFQCNList = array_diff($entityFQCNList, $ignoreNamespacePathList);
                if ($entityName === null) {
                    $doctrineBuildModel->addMessage('could not find valid DOMElement');
                    $doctrineBuildModel->setState(BuildState::BUILD_FAILED());
                    $doctrineBuildModelList[] = $doctrineBuildModel;

                    continue;
                }
                foreach ($addPathList as $offset => $_path) {
                    array_splice($entityFQCNList, $offset, 0, [$_path]);
                }
                $entityPath = implode('/', $entityFQCNList) . '/';
                $fieldList  = $this->getFieldList($DOMNode);

                $doctrineBuildModel->setBasePath($path);
                $doctrineBuildModel->setFieldList($fieldList);
                $doctrineBuildModel->setName($entityName);
                $doctrineBuildModel->setPath($entityPath);
                $doctrineBuildModel->setNameSpace($entityNameSpace);
                $doctrineBuildModel->setState(BuildState::READY());

                $doctrineAbstractBuildModel = clone $doctrineBuildModel;
                $doctrineAbstractBuildModel->setName($doctrineBuildModel->getName() . 'Extract');
                $doctrineAbstractBuildModel->setNameSpace($doctrineBuildModel->getNameSpace() . '\Extract');
                $doctrineAbstractBuildModel->setPath($doctrineBuildModel->getPath() . 'Extract/');

                $doctrineBuildModel->setFieldList([]);
                $doctrineBuildModel->addExtends($doctrineAbstractBuildModel->getNameSpace() . '\\' . $doctrineAbstractBuildModel->getName());
                $doctrineBuildModelList[] = $doctrineBuildModel;
                $doctrineBuildModelList[] = $doctrineAbstractBuildModel;
            }
        }

        return $doctrineBuildModelList;
    }

    /**
     * @param DoctrineBuildModel[] $doctrineBuildModelList
     * @return bool
     */
    public function buildDoctrineList(array $doctrineBuildModelList): bool
    {
        foreach ($doctrineBuildModelList as $doctrineBuildModel) {
            if (!$doctrineBuildModel->getState()->equals(BuildState::READY())) {
                continue;
            }
            if (!file_exists($doctrineBuildModel->getBasePath() . '/' . $doctrineBuildModel->getPath())) {
                $doctrineBuildModel->setState(BuildState::BUILD_FAILED());
                $doctrineBuildModel->addMessage('Path does not exist "' . $doctrineBuildModel->getBasePath() . '/' . $doctrineBuildModel->getPath() . '"');
                continue;
            }
            if (file_exists($doctrineBuildModel->getFilePath())) {
                $doctrineBuildModel->setState(BuildState::SUCCESS());
                $doctrineBuildModel->addMessage('File already exists "' . $doctrineBuildModel->getBasePath() . '/' . $doctrineBuildModel->getPath() . '"');
                continue;
            }
            $classBuilder = new ClassBuilder();
            $classBuilder->setNameSpace($doctrineBuildModel->getNameSpace());
            $classBuilder->setClassName($doctrineBuildModel->getName());
            $classBuilder->setExtends($doctrineBuildModel->getExtends());

            foreach ($doctrineBuildModel->getFieldList() as $_fieldName => $_fieldType) {
                if (!DoctrineType::isValidValue($_fieldType)) {
                    continue;
                }
                $phpType = $this->getPhpTypeForDoctrineType(DoctrineType::create($_fieldType));
                if ($phpType->equals(PhpType::DATETIME())) {
                    $classBuilder->addUseClass(DateTime::class);
                }
                $classBuilder->addCommentBlock(['@var ' . $phpType->getValue()]);
                $classBuilder->addContentLine('protected ' . $phpType->getValue() . ' $' . $_fieldName . ';');
            }
            if (file_put_contents($doctrineBuildModel->getFilePath(), $classBuilder->buildClass()) === false) {
                $doctrineBuildModel->setState(BuildState::BUILD_FAILED());
                $doctrineBuildModel->addMessage('failed: ' . $doctrineBuildModel->getFilePath());
            } else {
                $doctrineBuildModel->setState(BuildState::SUCCESS());
                $doctrineBuildModel->addMessage('success: ' . $doctrineBuildModel->getFilePath());
            }

        }

        return true;
    }

    /**
     * @param DOMElement $DOMNode
     * @return array
     */
    private function getFieldList(DOMElement $DOMNode): array
    {
        $constList = $this->getIdList($DOMNode);
        foreach ($DOMNode->getElementsByTagName('field') as $_DOMNode) {
            if (!$_DOMNode instanceof DOMElement) {
                continue;
            }
            $constList[$_DOMNode->getAttribute('name')] = $_DOMNode->getAttribute('type');
        }

        return $constList;
    }

    /**
     * @param DOMElement $DOMNode
     * @return array
     */
    private function getIdList(DOMElement $DOMNode): array
    {
        $constList = [];
        foreach ($DOMNode->getElementsByTagName('id') as $_DOMNode) {
            if (!$_DOMNode instanceof DOMElement) {
                continue;
            }
            $constList[$_DOMNode->getAttribute('name')] = $_DOMNode->getAttribute('type');
        }

        return $constList;
    }

    /**
     * @param DoctrineType $doctrineType
     * @return PhpType
     */
    private function getPhpTypeForDoctrineType(DoctrineType $doctrineType): PhpType
    {
        switch (true) {
            case $doctrineType->equals(DoctrineType::BIGINT()):
            case $doctrineType->equals(DoctrineType::SMALLINT()):
            case $doctrineType->equals(DoctrineType::INTEGER()):
            {
                return PhpType::INT();
            }
            case $doctrineType->equals(DoctrineType::SIMPLE_ARRAY()):
            case $doctrineType->equals(DoctrineType::ARRAY()):
            {
                return PhpType::ARRAY();
            }
            case $doctrineType->equals(DoctrineType::FLOAT()):
            case $doctrineType->equals(DoctrineType::DECIMAL()):
            {
                return PhpType::FLOAT();
            }
            case $doctrineType->equals(DoctrineType::BOOLEAN()):
            {
                return PhpType::BOOL();
            }
            case $doctrineType->equals(DoctrineType::DATETIME_MUTABLE()):
            {
                return PhpType::DATETIME();
            }
            default:
            {
                return PhpType::STRING();
            }
        }
    }

}