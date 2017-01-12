<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';


$app = \Token\Infrastructure\Silex\Application::bootstrap();

$app['debug'] = true;


$app->post('/', function () use ($app) {
    /** @var \Token\Application\Service\CreateTokenService $tokenCreation */
    $tokenCreation = $app['create_token']->execute();
    $token = $tokenCreation->token();
    $app['cache']->save((string)$token->id(), $token->expirationDatetime()->format('U'), $token->ttl());
    return $tokenCreation->response();
})->bind($app['create_token']::endpointName());


$app->get('/{tokenId}', function ($tokenId) use ($app) {
    $expirationTimestamp = $app['cache']->fetch($tokenId);
    /** @var \Token\Application\Service\ViewTokenService $tokenView */
    $tokenView = $app['view_token']->execute($tokenId, (new DateTime())->setTimestamp($expirationTimestamp));
    return $tokenView->response();
})->bind($app['view_token']::endpointName());


$app->delete('/{tokenId}', function ($tokenId) use ($app) {
    $expirationTimestamp = $app['cache']->fetch($tokenId);
    /** @var \Token\Application\Service\ExpireTokenService $tokenExpiration */
    $tokenExpiration = $app['expire_token']->execute($tokenId, (new DateTime())->setTimestamp($expirationTimestamp));
    return $tokenExpiration->response();
})->bind($app['expire_token']::endpointName());

$app->run();