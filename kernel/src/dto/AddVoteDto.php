<?php

namespace Mselyatin\Question\dto;

use Mselyatin\Question\dto\VoteDto;

/**
 * @author <selyatin83@mail.ru>
 */
class AddVoteDto extends VoteDto
{
    /** @var string  */
    public string $userIp;

    /**
     * @param string $userName
     * @param string $answer
     * @param int    $questionId
     * @param string $userIp
     */
    public function __construct(
        string $userName,
        string $answer,
        int $questionId,
        string $userIp
    ) {
        $this->user_name = $userName;
        $this->answer = $answer;
        $this->question_id = $questionId;
        $this->userIp = $userIp;
    }

    /**
     * @param string $userName
     * @param string $answer
     * @param int    $questionId
     * @param string $userIp
     *
     * @return static
     */
    public static function create(
        string $userName,
        string $answer,
        int $questionId,
        string $userIp
    ): self {
        return new self($userName, $answer, $questionId, $userIp);
    }
}
