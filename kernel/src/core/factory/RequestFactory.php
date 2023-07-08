<?php

namespace Mselyatin\Question\core\factory;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author <selyatin83@mail.ru>
 */
class RequestFactory
{
    public function create(): Request
    {
        return new Request(
            $_GET,
            $_POST,
            [],
            $_COOKIE,
            $_FILES,
            $_SERVER,
            null
        );
    }
}
