<?php

namespace PGrafe\PhpCodeGenerator\Cli\Command\Generate;

use Minicli\Command\CommandController;
use PGrafe\PhpCodeGenerator\Enum\BuildState;
use PGrafe\PhpCodeGenerator\Service\EnumService;

class OwnController extends CommandController
{
    public function handle()
    {
        $enumService = new EnumService();
        $enumBuildModelList = $enumService->getEnumBuildModelList(__DIR__ . '/../../../', ['PGrafe', 'PhpCodeGenerator'], [0 => 'src']);
        $this->getPrinter()->display('Found ' . count($enumBuildModelList) . ' enum(s) to build');
        $enumService->buildEnumList($enumBuildModelList);
        foreach ($enumBuildModelList as $enumBuildModel) {
            switch (true) {
                case $enumBuildModel->getState()->equals(BuildState::SUCCESS()):
                    $this->getPrinter()->success($enumBuildModel->getNameSpace() . '\\' . $enumBuildModel->getName());
                    break;
                case $enumBuildModel->getState()->equals(BuildState::NO_XML_FOUND()):
                    $this->getPrinter()->error('Invalid enum definition');
                    break;
                default:
                    $this->getPrinter()->info('State: ' . $enumBuildModel->getState()->getValue());
                    break;
            }
            foreach ($enumBuildModel->getMessageList() as $message) {
                $this->getPrinter()->display($message);
            }
        }
    }
}