<?php

namespace Mselyatin\Question\controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author <selyatin83@mail.ru>
 */
class MainController
{
    /**
     * @return JsonResponse
     */
    public function main(): JsonResponse
    {
        return new JsonResponse([
            'service' => 'Poll task API',
            'version' => '1.0'
        ]);
    }
}
