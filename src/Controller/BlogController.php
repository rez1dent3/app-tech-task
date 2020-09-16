<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController
{

    public function index(ContainerBuilder $builder, Request $request, EntityManager $entityManager): void
    {
        dd($request);
    }

}
