<?php

require __DIR__ . '/vendor/autoload.php';

use PGrafe\PhpCodeGenerator\Service\DoctrineService;

$path = __DIR__ . '/../win-pitmodule-de/pitcom-win.pitmodule.de/module';

$doctrineService        = new DoctrineService();
$doctrineBuildModelList = $doctrineService->getDoctrineBuildModelList($path, [], [1 => 'src']);
foreach ($doctrineBuildModelList as $doctrineBuildModel) {
    print_r($doctrineBuildModel->getMessageList());
}
$doctrineService->buildDoctrineList($doctrineBuildModelList);
foreach ($doctrineBuildModelList as $doctrineBuildModel) {
    print_r($doctrineBuildModel->getMessageList());
}