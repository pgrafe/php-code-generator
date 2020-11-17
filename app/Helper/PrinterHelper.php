<?php


namespace PGrafe\PhpCodeGenerator\Helper;


use Minicli\Output\OutputHandler;
use PGrafe\PhpCodeGenerator\Enum\BuildState;
use PGrafe\PhpCodeGenerator\Model\DoctrineBuildModel;
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
                    $outputHandler->info('Path "' . $enumBuildModel->getBasePath() . DIRECTORY_SEPARATOR . $enumBuildModel->getPath() . '" does not exist');
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

    /**
     * @param OutputHandler $outputHandler
     * @param DoctrineBuildModel[] $doctrineBuildModelList
     */
    public function displayDoctrineResult(OutputHandler $outputHandler, array $doctrineBuildModelList): void
    {
        foreach ($doctrineBuildModelList as $doctrineBuildModel) {
            switch (true) {
                case $doctrineBuildModel->getState()->equals(BuildState::SUCCESS()):
                    $outputHandler->success($doctrineBuildModel->getNameSpace() . '\\' . $doctrineBuildModel->getName());
                    break;
                case $doctrineBuildModel->getState()->equals(BuildState::NO_XML_FOUND()):
                    $outputHandler->error('Invalid entity definition');
                    break;
                case $doctrineBuildModel->getState()->equals(BuildState::BUILD_FAILED()):
                    $outputHandler->error('Build of entity failed!');
                    $outputHandler->info('Path "' . $doctrineBuildModel->getBasePath() . DIRECTORY_SEPARATOR . $doctrineBuildModel->getPath() . '" does not exist');
                    break;
                default:
                    $outputHandler->info('State: ' . $doctrineBuildModel->getState()->getValue());
                    break;
            }
            foreach ($doctrineBuildModel->getMessageList() as $message) {
                $outputHandler->display($message);
            }
        }
    }
}