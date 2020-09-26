<?php

//include __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../src/Service/EnumService.php';
include __DIR__ . '/../src/Service/XmlFileService.php';
include __DIR__ . '/../src/Builder/ClassBuilder.php';
include __DIR__ . '/../src/Model/EnumBuildModel.php';
include __DIR__ . '/../src/Model/EnumConstModel.php';

use PGrafe\PhpCodeGenerator\Service\EnumService;

$enumService = new EnumService();
$enumBuildModelList = $enumService->getEnumBuildModelList(__DIR__ . '/../', ['PGrafe', 'PhpCodeGenerator'], [0 => 'src']);
$enumService->buildEnumList($enumBuildModelList);
