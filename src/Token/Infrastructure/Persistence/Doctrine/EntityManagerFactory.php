<?php

namespace Token\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    /**
     * @return EntityManager
     */
    public function build($conn)
    {
        return EntityManager::create(
            $conn,
            Setup::createYAMLMetadataConfiguration([__DIR__ . '/Mapping'], true)
        );
    }
}