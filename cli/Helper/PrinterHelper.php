<?php


namespace PGrafe\PhpCodeGenerator\Cli\Helper;


use Minicli\Output\OutputHandler;
use PGrafe\PhpCodeGenerator\Enum\BuildState;
use PGrafe\PhpCodeGenerator\Model\EnumBuildModel;

class PrinterHelper
{

    /**
     * @param OutputHandler $outputHandler
     * @param EnumBuildModel[] $enumBuildModelList
     */
    public function displayEnumResult(OutputHandler $outputHandler, array $enumBuildModelList): void
    {
        foreach ($enumBuildModelList as $enumBuildModel) {
            switch (true) {
                case $enumBuildModel->getState()->equals(BuildState::SUCCESS()):
                    $outputHandler->success($enumBuildModel->getNameSpace() . '\\' . $enumBuildModel->getName());
                    break;
                case $enumBuildModel->getState()->equals(BuildState::NO_XML_FOUND()):
                    $outputHandler->error('Invalid enum definition');
                    break;
                case $enumBuildModel->getState()->equals(BuildState::BUILD_FAILED()):
                    $outputHandler->error('Build of enum failed!');
                    $outputHandler->info('Path "' . $enumBuildModel->getBasePath() . '/' . $enumBuildModel->getPath() . '" does not exist');
                    break;
                default:
                    $outputHandler->info('State: ' . $enumBuildModel->getState()->getValue());
                    break;
            }
            foreach ($enumBuildModel->getMessageList() as $message) {
                $outputHandler->display($message);
            }
        }
    }
}