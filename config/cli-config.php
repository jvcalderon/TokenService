<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Token\Infrastructure\Persistence\Doctrine\EntityManagerFactory;

$app = \Token\Infrastructure\Silex\Application::bootstrap();

// replace with mechanism to retrieve EntityManager in your app
$entityManager = (new EntityManagerFactory())->build($app['db']);

return ConsoleRunner::createHelperSet($entityManager);
