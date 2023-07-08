<?php

namespace Mselyatin\Question\controllers;

use Mselyatin\Question\core\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author <selyatin83@mail.ru>
 */
abstract class BaseController
{
    /** @var SerializerInterface  */
    protected SerializerInterface $serializer;

    /** @var Request  */
    protected Request $request;

    public function __construct()
    {
        $this->serializer = Kernel::$container->get(SerializerInterface::class);
        $this->request = Kernel::$container->get(Request::class);
    }

    /**
     * @param string $data
     * @param string $type
     *
     * @return mixed
     */
    protected function deserialize(string $data, string $type): mixed
    {
        return $this->serializer->deserialize(
            $data,
            $type,
            'json',
            [AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]
        );
    }
}
