<?php

// twig container
$container->set('twig', function() {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . $_ENV['TEMPLATE_PATH']);
    $twig = new \Twig\Environment($loader, [
        'cache' => ($_ENV['ENV'] == 'prod') ? __DIR__ . $_ENV['CACHE_PATH'] : false,
    ]);

    return $twig;
});

// db containers
$container->set('db', function() {
    $capsule = new Illuminate\Database\Capsule\Manager();
    $capsule->addConnection([
        'driver'    => $_ENV['DB_DRIVER'],
        'host'      => $_ENV['DB_HOST'],
        'database'  => $_ENV['DB_NAME'],
        'username'  => $_ENV['DB_USER'],
        'password'  => $_ENV['DB_PASSWORD'],
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container()));

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
});

// respect validation container
$container->set('validator', function() {
    return new Respect\Validation\Validator();
});

// flash messages
$container->set('flash', function() {
    return new \Slim\Flash\Messages();
});

$container->set('mailer', function() {
    // Create the Transport
    $transport = (new Swift_SmtpTransport($_ENV['MAIL_HOST'], $_ENV['MAIL_PORT']))
        ->setUsername($_ENV['MAIL_USER'])
        ->setPassword($_ENV['MAIL_PASSWORD'])
    ;

    return new Swift_Mailer($transport);
});

$container->set('logger', function() {
    $logger = new \Monolog\Logger('app');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . $_ENV['LOG_PATH'], \Monolog\Logger::INFO));
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . $_ENV['LOG_PATH'], \Monolog\Logger::WARNING));
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . $_ENV['LOG_PATH'], \Monolog\Logger::ERROR));
    $logger->pushHandler(new \Monolog\Handler\FirePHPHandler());
    return $logger;
});