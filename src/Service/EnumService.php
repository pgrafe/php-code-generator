<?php


namespace PGrafe\PhpCodeGenerator\Service;


use DOMElement;
use PGrafe\PhpCodeGenerator\Builder\ClassBuilder;
use PGrafe\PhpCodeGenerator\Enum\BuildState;
use PGrafe\PhpCodeGenerator\Model\EnumBuildModel;
use PGrafe\PhpCodeGenerator\Model\EnumConstModel;


class EnumService
{
    /**
     * @param string $path
     * @param array $ignoreNamespacePathList
     * @param array $addPathList
     * @return EnumBuildModel[]
     */
    public function getEnumBuildModelList(string $path, array $ignoreNamespacePathList, array $addPathList): array
    {
        $xmlFileService = new XmlFileService();
        $nicePath = $xmlFileService->buildNicePath($path);
        $enumBuildModelList = [];
        $domDocumentList = $xmlFileService->getEnumDomDocumentList($nicePath);
        if (count($domDocumentList) === 0) {
            $enumBuildModel = new EnumBuildModel();
            $enumBuildModel->addMessage('could not find any XML file beneath: ' . $nicePath);
            $enumBuildModel->setState(BuildState::NO_XML_FOUND());
            $enumBuildModelList[] = $enumBuildModel;

            return $enumBuildModelList;
        }
        foreach ($domDocumentList as $DOMDocument) {
                $enumBuildModel = new EnumBuildModel();
                $enumBuildModel->setState(BuildState::READY());
                $DOMNode = $DOMDocument->getElementsByTagName('definition')->item(0);
                if (!$DOMNode instanceof DOMElement) {
                    $enumBuildModel->addMessage('could not find valid DOMElement');
                    $enumBuildModelList[] = $enumBuildModel;
                    $enumBuildModel->setState(BuildState::BUILD_FAILED());

                    continue;
                }
                $enumFQDN = $DOMNode->getAttribute('fqcn');
                $enumFQDNList = explode('\\', $enumFQDN);
                $enumName = array_pop($enumFQDNList);
                $enumNameSpace = implode('\\', $enumFQDNList);
                $enumFQDNList = array_diff($enumFQDNList, $ignoreNamespacePathList);
                $enumType = $DOMNode->getAttribute('type');
                if ($enumName === null) {
                    $enumBuildModel->addMessage('could not find valid DOMElement');
                    $enumBuildModelList[] = $enumBuildModel;

                    continue;
                }
                foreach ($addPathList as $offset => $_path) {
                    array_splice($enumFQDNList, $offset, 0, [$_path]);
                }
                $enumPath = implode('/', $enumFQDNList) . '/';
                $constList = $this->getConstList($DOMNode);
                $commentList = $this->getCommentList($DOMNode);

                $enumBuildModel->setBasePath($nicePath);
                $enumBuildModel->setConstList($constList);
                $enumBuildModel->setCommentList($commentList);
                $enumBuildModel->setName($enumName);
                $enumBuildModel->setType($enumType);
                $enumBuildModel->setPath($enumPath);
                $enumBuildModel->setNameSpace($enumNameSpace);
                $enumBuildModel->setState(BuildState::READY());

                $enumBuildModelList[] = $enumBuildModel;
            }

        return $enumBuildModelList;
    }

    /**
     * @param EnumBuildModel[] $enumBuildModelList
     * @return void
     */
    public function buildEnumList(array $enumBuildModelList): void
    {
        foreach ($enumBuildModelList as $enumBuildModel) {
            if (!$enumBuildModel->getState()->equals(BuildState::READY())) {
                continue;
            }
            $classBuilder = new ClassBuilder();
            $classBuilder->setNameSpace($enumBuildModel->getNameSpace());
            $classBuilder->setClassName($enumBuildModel->getName());
            $classBuilder->addUseClass('InvalidArgumentException');
            $classBuilder->setCommentList($enumBuildModel->getCommentList());

            $classBuilder->addCommentBlock(['@var ' . $enumBuildModel->getType()]);
            $classBuilder->addContentLine('private ' . $enumBuildModel->getType() . ' $value;');
            foreach ($enumBuildModel->getConstList() as $enumConstModel) {
                $classBuilder->addCommentBlock([$enumConstModel->getComment(), '@var ' . $enumBuildModel->getType()]);
                if ($enumBuildModel->getType() === 'int') {
                    $classBuilder->addContentLine('private const ' . $enumConstModel->getName() . ' = ' . $enumConstModel->getValue() . ';');
                } else {
                    $classBuilder->addContentLine('private const ' . $enumConstModel->getName() . ' = \'' . $enumConstModel->getValue() . '\';');
                }
                $classBuilder->addCommentBlock([$enumConstModel->getComment(), '@return ' . $enumBuildModel->getName()]);
                $classBuilder->addContentLine('public static function ' . $enumConstModel->getName() . '(): ' . $enumBuildModel->getName());
                $classBuilder->addContentLine('{');
                $classBuilder->addContentLine('return new self(self::' . $enumConstModel->getName() . ');');
                $classBuilder->addContentLine('}');
            }
            $classBuilder->addCommentBlock(['@return ' . $enumBuildModel->getType() . '[]']);
            $classBuilder->addContentLine('public static function getConstList(): array');
            $classBuilder->addContentLine('{');
            foreach ($enumBuildModel->getConstList() as $enumConstModel) {
                $classBuilder->addContentLine('$constList[\'' . $enumConstModel->getName() . '\'] = self::' . $enumConstModel->getName() . ';');
            }
            $classBuilder->addContentLine('');
            $classBuilder->addContentLine('return $constList;');
            $classBuilder->addContentLine('}');

            $classBuilder->addCommentBlock(
                [
                    '@param ' . $enumBuildModel->getType() . ' $value',
                    '@return ' . $enumBuildModel->getName(),
                ]
            );
            $classBuilder->addContentLine('public static function create(' . $enumBuildModel->getType() . ' $value): ' . $enumBuildModel->getName());
            $classBuilder->addContentLine('{');
            $classBuilder->addContentLine('foreach (self::getConstList() as $_const => $_value) {');
            $classBuilder->addContentLine('if ($value === $_value) {');
            $classBuilder->addContentLine('return self::$_const();');
            $classBuilder->addContentLine('}');
            $classBuilder->addContentLine('}');

            $classBuilder->addContentLine('throw new InvalidArgumentException(\'invalid enum value: "\' . $value . \'"\');');
            $classBuilder->addContentLine('}');

            $classBuilder->addCommentBlock(
                [
                    '@param ' . $enumBuildModel->getType() . ' $value',
                    '@return bool',
                ]
            );
            $classBuilder->addContentLine('public static function isValidValue(' . $enumBuildModel->getType() . ' $value): bool');
            $classBuilder->addContentLine('{');
            $classBuilder->addContentLine('return in_array($value, self::getConstList(), true);');
            $classBuilder->addContentLine('}');

            $classBuilder->addCommentBlock(
                [
                    $enumBuildModel->getName() . ' constructor',
                    '@param ' . $enumBuildModel->getType() . ' $value',
                ]
            );
            $classBuilder->addContentLine('private function __construct(' . $enumBuildModel->getType() . ' $value)');
            $classBuilder->addContentLine('{');
            $classBuilder->addContentLine('$this->value = $value;');
            $classBuilder->addContentLine('}');

            $classBuilder->addCommentBlock(
                [
                    '@param ' . $enumBuildModel->getName() . ' $' . lcfirst($enumBuildModel->getName()),
                    '@return bool',
                ]
            );
            $classBuilder->addContentLine('public function equals(' . $enumBuildModel->getName() . ' $' . lcfirst($enumBuildModel->getName()) . '): bool');
            $classBuilder->addContentLine('{');
            $classBuilder->addContentLine('return $' . lcfirst($enumBuildModel->getName()) . '->getValue() === $this->getValue();');
            $classBuilder->addContentLine('}');

            $classBuilder->addCommentBlock(['@return ' . $enumBuildModel->getType()]);
            $classBuilder->addContentLine('public function getValue(): ' . $enumBuildModel->getType());
            $classBuilder->addContentLine('{');
            $classBuilder->addContentLine('return $this->value;');
            $classBuilder->addContentLine('}');

            file_put_contents($enumBuildModel->getFilePath(), $classBuilder->buildClass());
            $enumBuildModel->setState(BuildState::SUCCESS());
            $enumBuildModel->addMessage('successfully build in "' . $enumBuildModel->getPath() . '"');
        }
    }

    /**
     * @param DOMElement $DOMNode
     * @return EnumConstModel[]
     */
    private function getConstList(DOMElement $DOMNode): array
    {
        $constList = [];
        foreach ($DOMNode->getElementsByTagName('const') as $_DOMNode) {
            if (!$_DOMNode instanceof DOMElement) {
                continue;
            }
            $enumConstModel = new EnumConstModel();
            $enumConstModel->setName($_DOMNode->getAttribute('name'));
            $enumConstModel->setValue($_DOMNode->getAttribute('value'));
            $enumConstModel->setComment($_DOMNode->getAttribute('comment'));
            $constList[$enumConstModel->getName()] = $enumConstModel;
        }

        return $constList;
    }

    /**
     * @param DOMElement $DOMNode
     * @return string[]
     */
    private function getCommentList(DOMElement $DOMNode): array
    {
        $commentList = [];
        foreach ($DOMNode->getElementsByTagName('comment') as $_DOMNode) {
            if (!$_DOMNode instanceof DOMElement) {
                continue;
            }
            $commentList[] = $_DOMNode->nodeValue;
        }

        return $commentList;
    }

}