<?php

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @var ContainerBuilder $container
 */
$container = include dirname(__DIR__) . '/bootstrap.php';

/**
 * Development mode
 */
if (strpos($container->getParameter('app.env'), 'dev') === 0) {
    Debug::enable();
}

/**
 * @var HttpKernel $kernel
 */
$kernel = $container->get('kernel');

/**
 * @var Request $request
 */
$request = $container->get('request');
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
