<?php

namespace Mselyatin\Question\core\factory;

use Mselyatin\Question\responses\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author <selyatin83@mail.ru>
 */
class ErrorFactory
{
    public const SYSTEM_ERROR = 1;
    public const PAGE_NOT_FOUND_ERROR = 4;
    public const RESPONSE_TYPE_IS_NOT_CORRECT = 5;
    public const VALIDATION_ERROR = 6;

    public static array $errorDetails = [
        self::PAGE_NOT_FOUND_ERROR => [
            'status' => Response::HTTP_NOT_FOUND,
            'message' => 'Page not found'
        ],
        self::SYSTEM_ERROR => [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'System error'
        ],
        self::VALIDATION_ERROR => [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'Validation error'
        ]
    ];

    /**
     * @param int         $code
     * @param string|null $customMessage
     * @param array|null  $extra
     *
     * @return JsonResponse
     */
    public static function get(
        int $code,
        ?string $customMessage = null,
        ?array $extra = []
    ): JsonResponse {
        if (!array_key_exists($code, static::$errorDetails)) {
            return new JsonResponse(
                new ErrorResponse($code, 'System error'),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $errorDetail = static::$errorDetails[$code];
        $status = $errorDetail['status'] ?? null;
        $message = $customMessage === null
            ? ($errorDetail['message'] ?? null)
            : $customMessage;

        if (!$status || !$message) {
            return new JsonResponse(
                new ErrorResponse($code, 'System error'),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            new ErrorResponse($code, $message, $extra),
            $status
        );
    }
}
