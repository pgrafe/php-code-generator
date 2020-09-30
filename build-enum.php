<?php

require __DIR__ . '/vendor/autoload.php';

use PGrafe\PhpCodeGenerator\Service\EnumService;

$path = __DIR__ . '/../win-pitmodule-de/pitcom-win.pitmodule.de/module';

$enumService        = new EnumService();
$enumBuildModelList = $enumService->getEnumBuildModelList($path, [], [1 => 'src']);
foreach ($enumBuildModelList as $enumBuildModel) {
    print_r($enumBuildModel->getMessageList());
}
$enumService->buildEnumList($enumBuildModelList);
foreach ($enumBuildModelList as $enumBuildModel) {
    print_r($enumBuildModel->getMessageList());
}