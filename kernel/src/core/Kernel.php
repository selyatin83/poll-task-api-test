<?php

namespace Mselyatin\Question\core;

use Psr\Container\ContainerInterface;

/**
 * This is the main application class
 *
 * @author <selyatin83@mail.ru>
 */
class Kernel
{
    /** @var ContainerInterface  */
    public static ContainerInterface $container;

    /** @var Routing  */
    private Routing $routing;

    /**
     * @param ContainerInterface $container
     * @param Routing            $routing
     */
    public function __construct(
        ContainerInterface $container,
        Routing $routing
    ) {
        static::$container = $container;
        $this->routing = $routing;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $response = $this->routing->handle();
        http_response_code($response->getStatusCode());
        header('Content-Type: application/json; charset=utf-8');
        echo $response->getContent();
    }
}
