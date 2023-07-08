<?php

namespace Mselyatin\Question\core\factory;

use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @author <selyatin83@mail.ru>
 */
class DatabaseConnectionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return Connection
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(ContainerInterface $container): Connection
    {
        $factory = new ConnectionFactory(new Container());
        return $factory->make($container->get('config')['db'] ?? []);
    }
}
