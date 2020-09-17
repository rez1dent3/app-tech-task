<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

include_once __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/.env');
}

// register DI
$container = new ContainerBuilder();
$container->setParameter('root_dir', __DIR__);

$locator = new FileLocator(__DIR__ . '/config');
$container->set('locator', $locator); // global register @locator

// loading components into DI
$diLoader = new YamlFileLoader($container, $locator);
$diLoader->load('components.yaml');

// collect env for doctrine to work
$container->compile(true);

return $container;
