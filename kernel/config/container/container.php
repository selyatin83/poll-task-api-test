<?php

use Illuminate\Database\Connection;
use Mselyatin\Question\core\factory\DatabaseConnectionFactory;
use Mselyatin\Question\core\factory\RequestFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Mselyatin\Question\core\Routing;

$repositories = require_once('repositories.php');
$services = require_once('services.php');

return
    $services +
    $repositories +
    [
        'base.dir' => dirname(__DIR__, 2),
        'config.dir' => \DI\factory(function (ContainerInterface $container) {
            return $container->get('base.dir') . '/config';
        }),
        'config' => function (ContainerInterface $container) {
            return require_once( $container->get('config.dir') . '/config.php');
        },
        Connection::class => \DI\factory([DatabaseConnectionFactory::class, 'create']),
        SerializerInterface::class => \DI\factory(function () {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            return new Serializer($normalizers, $encoders);
        }),
        Routing::class => \DI\factory(function (ContainerInterface $container) {
            return new Routing(
                $container->get('config.dir'),
                'routes.yaml'
            );
        }),
        Request::class => \DI\factory([RequestFactory::class, 'create'])
    ];