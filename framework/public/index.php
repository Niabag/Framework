<?php

use DI\Container;
use Slim\Factory\AppFactory;

session_start();

require __DIR__ . '/../vendor/autoload.php';


// .env
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// create container system with PHP-DI
$container = new Container();

// register custom container
require __DIR__ . '/../config/containers.php';

// register container into app
AppFactory::setContainer($container);

// create slim application
$app = AppFactory::create();

$app->getContainer()->get('db');

// register routes in app
require __DIR__ . '/../config/routes.php';

// start application
$app->run();