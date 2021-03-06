<?php

namespace PGrafe\PhpCodeGenerator\Command\Generate;

use PGrafe\PhpCodeGenerator\Helper\PrinterHelper;
use Minicli\Command\CommandController;
use PGrafe\PhpCodeGenerator\Service\DoctrineService;

class DoctrineController extends CommandController
{

    public function handle()
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
        $doctrineService = new DoctrineService();
        $doctrineBuildModelList = $doctrineService->getDoctrineBuildModelList($path, [], [0 => 'src']);
        $this->getPrinter()->display('Found ' . count($doctrineBuildModelList) . ' entitie(s) to build');
        $doctrineService->buildDoctrineList($doctrineBuildModelList);
        $printerHelper = new PrinterHelper();
        $printerHelper->displayDoctrineResult($this->getPrinter(), $doctrineBuildModelList);
    }
}