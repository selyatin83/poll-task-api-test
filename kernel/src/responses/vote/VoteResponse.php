<?php

namespace Mselyatin\Question\responses\vote;

use JsonSerializable;
use \stdClass;

/**
 * @author <selyatin83@mail.ru>
 */
readonly class VoteResponse implements JsonSerializable
{
    /**
     * @param stdClass $row
     */
    public function __construct(public stdClass $row) {}

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'user_name' => $this->row->user_name ?? null,
            'answer' => $this->row->answer ?? null,
            'created_at' => $this->row->created_at ?? null
        ];
    }
}
