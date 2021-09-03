<?php

use app\Application;

require_once './vendor/autoload.php';

/** @var Application $app */
$app = \app\ContainerAdapter::get(Application::class);
$app->run();
