<?php

namespace Mselyatin\Question\exceptions;

use Exception;
use Throwable;

/**
 * @author <selyatin83@mail.ru>
 */
class ClientErrorException extends Exception
{
    /** @var int  */
    protected int $clientCodeError;

    /** @var array|null  */
    protected ?array $extra = [];

    public function __construct(
        int $clientCodeError,
        string $message = "",
        ?array $extra = [],
        int $code = 0,
        ?Throwable $previous = null
    )  {
        parent::__construct($message, $code, $previous);
        $this->clientCodeError = $clientCodeError;
        $this->extra = $extra;
    }

    /**
     * @return int
     */
    public function getClientCodeError(): int
    {
        return $this->clientCodeError;
    }

    /**
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }
}
