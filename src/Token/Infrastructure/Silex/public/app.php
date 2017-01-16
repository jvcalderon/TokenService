<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

$app = \Token\Infrastructure\Silex\Application::bootstrap();


$app->post('/', function () use ($app) {
    return $app['create_token']->execute();
})->bind($app['create_token']::endpointName());


$app->get('/{tokenId}', function ($tokenId) use ($app) {
    $expirationTimestamp = $app['cache']->fetch($tokenId);
    return $app['view_token']->execute($tokenId, (new DateTime())->setTimestamp($expirationTimestamp));
})->bind($app['view_token']::endpointName());


$app->delete('/{tokenId}', function ($tokenId) use ($app) {
    $expirationTimestamp = $app['cache']->fetch($tokenId);
    return $app['expire_token']->execute($tokenId, (new DateTime())->setTimestamp($expirationTimestamp));
})->bind($app['expire_token']::endpointName());


$app->run();