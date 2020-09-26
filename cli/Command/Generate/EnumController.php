<?php

namespace PGrafe\PhpCodeGenerator\Cli\Command\Generate;

use Minicli\Command\CommandController;
use PGrafe\PhpCodeGenerator\Cli\Helper\PrinterHelper;
use PGrafe\PhpCodeGenerator\Service\EnumService;

class EnumController extends CommandController
{
    /**
     *
     */
    public function handle(): void
    {
        if (!$this->hasParam('path')) {
            $this->getPrinter()->info('Please add path=<build-path>');

            return;
        }
        $path = realpath($this->getParam('path'));
        if (!file_exists($path)) {
            $this->getPrinter()->error('Please enter valid path');

            return;
        }
        $enumService = new EnumService();
        $enumBuildModelList = $enumService->getEnumBuildModelList($path, ['PGrafe', 'PhpCodeGenerator'], [0 => 'src']);
        $this->getPrinter()->display('Found ' . count($enumBuildModelList) . ' enum(s) to build');
        $enumService->buildEnumList($enumBuildModelList);
        $printerHelper = new PrinterHelper();
        $printerHelper->displayEnumResult($this->getPrinter(), $enumBuildModelList);
    }
}