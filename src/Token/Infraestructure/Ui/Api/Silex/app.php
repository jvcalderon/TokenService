<?php

require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use JMS\Serializer\SerializerBuilder;
use Token\Domain\Entity\Token;
use Token\Domain\Entity\TokenId;

$app = new Silex\Application();

$app->get('/', function () use ($app) {
    return 'ddd';
});

$app['debug'] = true;

$app->run();