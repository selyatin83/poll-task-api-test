<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Mselyatin\Question\core\factory\ContainerFactory;
use Mselyatin\Question\core\Kernel;

require __DIR__.'/../../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotEnv->load();

$containerDefinitions = require_once(dirname(__DIR__) . '/config/container/container.php');
$container = ContainerFactory::create($containerDefinitions);

/** @var Kernel $app */
$app = $container->get(Kernel::class);
$app->run();