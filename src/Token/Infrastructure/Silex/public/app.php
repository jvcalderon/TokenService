<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Token\Application\Service\CreateTokenService;

$app = \Token\Infrastructure\Silex\Application::bootstrap();

$app['debug'] = true;


$app->post('/', function () use ($app) {
    /** @var CreateTokenService $tokenCreation */
    $tokenCreation = $app['create_token']->execute();
    $token = $tokenCreation->token();
    $app['cache']->save((string)$token->id(), $token->expirationDatetime()->format('U'), $token->ttl());
    return $tokenCreation->response();
})->bind($app['create_token']::ENDPOINT_NAME);


$app->get('/{tokenId}', function ($tokenId) use ($app) {
    $expirationTimestamp = $app['cache']->fetch($tokenId);
    return $app['view_token']->execute($tokenId, (new DateTime())->setTimestamp($expirationTimestamp));
})->bind($app['view_token']::ENDPOINT_NAME);


$app->run();