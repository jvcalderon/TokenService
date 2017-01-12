<?php

namespace Token\Infrastructure\Silex;

use Ddd\Domain\DomainEventPublisher;
use Ddd\Domain\PersistDomainEventSubscriber;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\ORM\EntityManager;
use Hateoas\HateoasBuilder;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Token\Application\Service\CreateTokenService;
use Token\Application\Service\ExpireTokenService;
use Token\Application\Service\ViewTokenService;
use Token\Infrastructure\Persistence\Doctrine\EntityManagerFactory;

class Application
{
    public static function bootstrap()
    {

        AnnotationRegistry::registerLoader('class_exists');

        $app = new \Silex\Application();

        $app->register(new RoutingServiceProvider());

        $app->register(new DoctrineServiceProvider, [
            'db.options' => [
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/../../../../db.sqlite'
            ]
        ]);

        $app['em'] = function ($app) {
            return (new EntityManagerFactory())->build($app['db']);
        };

        $app['event_store'] = function ($app) {
            /** @var EntityManager $em */
            $em = $app['em'];
            return $em->getRepository('Ddd\Domain\Event\StoredEvent');
        };

        $app['cache'] = function () {
            $redis = new \Redis();
            $redis->connect('redis');
            $cacheDriver = new RedisCache();
            $cacheDriver->setRedis($redis);

            return $cacheDriver;
        };

        $app['serializer'] = HateoasBuilder::create()
            ->setUrlGenerator(null, new SymfonyUrlGenerator($app['url_generator']))
            ->build()
        ;

        $app['create_token'] = function ($app) {
            return new CreateTokenService($app['url_generator']);
        };

        $app['view_token'] = function ($app) {
            return new ViewTokenService($app['serializer']);
        };

        $app['expire_token'] = function () {
            return new ExpireTokenService();
        };

        $app->before(function () use ($app) {
            DomainEventPublisher::instance()->subscribe(
                new PersistDomainEventSubscriber(
                    $app['event_store']
                )
            );
        });

        return $app;
    }
}