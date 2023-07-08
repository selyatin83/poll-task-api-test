<?php

namespace Mselyatin\Question\dto;

/**
 * @author <selyatin83@mail.ru>
 */
class VoteDto
{
    /** @var string|null  */
    public ?string $user_name = null;

    /** @var int|null  */
    public ?int $question_id = null;

    /** @var string|null  */
    public ?string $answer = null;
}
