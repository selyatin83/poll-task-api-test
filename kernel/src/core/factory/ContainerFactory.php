<?php

namespace Mselyatin\Question\core\factory;

use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;

/**
 * @author <selyatin83@mail.ru>
 */
class ContainerFactory
{
    /** @var ContainerInterface */
    private static ContainerInterface $container;

    /**
     * @throws Exception
     */
    public static function create(array $definitions): ContainerInterface
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $builder->useAutowiring(true);

        return $builder->build();
    }
}
