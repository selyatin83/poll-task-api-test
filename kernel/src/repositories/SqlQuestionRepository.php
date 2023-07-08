<?php

namespace Mselyatin\Question\repositories;

use Illuminate\Database\Connection;
use Mselyatin\Question\dto\QuestionDto;
use Mselyatin\Question\repositories\interfaces\QuestionRepositoryInterface;
use Mselyatin\Question\responses\vote\VoteResponse;
use Mselyatin\Question\services\Pager;

/**
 * @author <selyatin83@mail.ru>
 */
class SqlQuestionRepository implements QuestionRepositoryInterface
{
    public const NAME_TABLE = 'question';

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
     * @param QuestionDto $questionDto
     *
     * @return int
     */
    public function add(QuestionDto $questionDto): int
    {
        $answersJson = json_encode(array_values($questionDto->answers), JSON_UNESCAPED_UNICODE);

        return $this->connection
            ->table(self::NAME_TABLE)
            ->insertGetId([
                'question' => $questionDto->question,
                'answers' => $answersJson
            ]);
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $question = $this->connection
            ->table(self::NAME_TABLE)
            ->select()
            ->where('id', '=', $id)
            ->get()
            ?->first();

        return $question !== null
            ? array($question)
            : null;
    }

    /**
     * @param int    $questionId
     * @param string $answer
     *
     * @return bool
     */
    public function isAnswerExist(int $questionId, string $answer): bool
    {
        return $this->connection
            ->table(self::NAME_TABLE)
            ->where('id', '=', $questionId)
            ->where('answers', '@>', "\"{$answer}\"")
            ->exists();
    }

    /**
     * @param int $questionId
     *
     * @return bool
     */
    public function isQuestionExistById(int $questionId): bool
    {
        return $this->connection
            ->table(self::NAME_TABLE)
            ->where('id', '=', $questionId)
            ->exists();
    }

    /**
     * @param int   $questionId
     * @param Pager $pager
     *
     * @return array
     */
    public function votesById(int $questionId, Pager $pager): array
    {
        $rows = $this->connection
            ->table(self::NAME_TABLE . ' as q')
            ->select(['v.user_name', 'v.answer', 'v.created_at'])
            ->leftJoin('vote as v', 'id', '=', 'question_id')
            ->where('q.id', '=', $questionId)
            ->limit($pager->getLimit())
            ->offset($pager->getOffset())
            ->orderBy('v.created_at', 'asc')
            ->get()
            ->toArray();

        return array_map(function (\stdClass $row) {
            return new VoteResponse($row);
        }, $rows);
    }
}
