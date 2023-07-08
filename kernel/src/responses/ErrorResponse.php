<?php

namespace Mselyatin\Question\responses;

use JsonSerializable;

/**
 * @author <selyatin83@mail.ru>
 */
readonly class ErrorResponse implements JsonSerializable
{
    /**
     * @param int    $code
     * @param string $message
     * @param array  $extra
     */
    public function __construct(
        public int $code,
        public string $message,
        public array $extra = []
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'extra' => $this->extra
        ];
    }
}
