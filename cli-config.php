<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;

/**
 * @var ContainerBuilder $container
 */
$container = include __DIR__ . '/bootstrap.php';

/**
 * @var EntityManager $entityManager
 */
$entityManager = $container->get('doctrine.entity_manager');

return ConsoleRunner::createHelperSet($entityManager);
