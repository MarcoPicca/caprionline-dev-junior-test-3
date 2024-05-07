<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerBuilder $container, $c = null)
    {
        $container->loadFromExtension('framework', [
            'secret' => '%env(APP_SECRET)%',
            'cors' => [
                'allow_origin' => ['*'],
                'allow_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'allow_headers' => ['Content-Type', 'Authorization'],
                'expose_headers' => [],
                'max_age' => 3600,
            ],
        ]);

        parent::configureContainer($container, $c);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__.'/Controller/', '/', 'annotation');
    }
    protected function handleRequest(Request $request, $catch = true)
    {
        $response = parent::handleRequest($request, $catch);

        
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}