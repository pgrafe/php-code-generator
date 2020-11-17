<?php

namespace PGrafe\PhpCodeGenerator\Command\Generate;

use Minicli\Command\CommandController;
use PGrafe\PhpCodeGenerator\Helper\PrinterHelper;
use PGrafe\PhpCodeGenerator\Service\EnumService;

class OwnController extends CommandController
{

    public function handle()
    {
        $enumService        = new EnumService();
        $pathChange         = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        $enumBuildModelList = $enumService->getEnumBuildModelList(realpath(__DIR__ . $pathChange), ['PGrafe', 'PhpCodeGenerator'], [0 => 'app']);
        $this->getPrinter()->display('Found ' . count($enumBuildModelList) . ' enum(s) to build');
        $enumService->buildEnumList($enumBuildModelList);
        $printerHelper = new PrinterHelper();
        $printerHelper->displayEnumResult($this->getPrinter(), $enumBuildModelList);
    }
}