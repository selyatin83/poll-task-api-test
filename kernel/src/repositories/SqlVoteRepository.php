<?php

namespace Mselyatin\Question\repositories;

use Illuminate\Database\Connection;
use Mselyatin\Question\dto\AddVoteDto;
use Mselyatin\Question\repositories\interfaces\VoteRepositoryInterface;

/**
 * @author <selyatin83@mail.ru>
 */
class SqlVoteRepository implements VoteRepositoryInterface
{
    public const NAME_TABLE = 'vote';

    /** @var Connection  */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * It is support "=" only
     *
     * @param array $filter
     *
     * @return array
     */
    public function getByAndFilter(array $filter): array
    {
        $query = $this->connection
            ->table(self::NAME_TABLE)
            ->select();

        foreach ($filter as $column => $value) {
            $query->where($column, '=', $value);
        }

        $items = $query->get();
        return $items->all();
    }

    /**
     * @param int    $questionId
     * @param string $userIp
     *
     * @return bool
     */
    public function isExistVoteByIp(int $questionId, string $userIp): bool
    {
        return $this->connection
            ->table(self::NAME_TABLE)
            ->select()
            ->where('question_id', '=', $questionId)
            ->where('user_ip', '=', $userIp)
            ->exists();
    }

    /**
     * @param AddVoteDto $voteDto
     *
     * @return bool
     */
    public function add(AddVoteDto $voteDto): bool
    {
        return $this->connection
            ->table(self::NAME_TABLE)
            ->insert([
                'user_name' => $voteDto->user_name,
                'answer' => $voteDto->answer,
                'question_id' => $voteDto->question_id,
                'user_ip' => $voteDto->userIp
            ]);
    }
}
