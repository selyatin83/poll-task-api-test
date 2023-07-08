<?php

namespace Mselyatin\Question\repositories\interfaces;

use Mselyatin\Question\dto\AddVoteDto;

/**
 * @author <selyatin83@mail.ru>
 */
interface VoteRepositoryInterface
{
    /**
     * @param AddVoteDto $voteDto
     *
     * @return int
     */
    public function add(AddVoteDto $voteDto): bool;

    /**
     * @param array $filter
     *
     * @return array
     */
    public function getByAndFilter(array $filter): array;

    /**
     * @param int    $questionId
     * @param string $userIp
     *
     * @return bool
     */
    public function isExistVoteByIp(int $questionId, string $userIp): bool;
}
