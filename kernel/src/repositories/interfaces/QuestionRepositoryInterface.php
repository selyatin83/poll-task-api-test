<?php

namespace Mselyatin\Question\repositories\interfaces;

use Mselyatin\Question\dto\QuestionDto;
use Mselyatin\Question\services\Pager;

/**
 * @author <selyatin83@mail.ru>
 */
interface QuestionRepositoryInterface
{
    /**
     * Add new a question
     *
     * @param QuestionDto $questionDto
     *
     * @return int
     */
    public function add(QuestionDto $questionDto): int;

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function getById(int $id): ?array;

    /**
     * @param int    $questionId
     * @param string $answer
     *
     * @return bool
     */
    public function isAnswerExist(int $questionId, string $answer): bool;

    /**
     * @param int $questionId
     *
     * @return bool
     */
    public function isQuestionExistById(int $questionId): bool;

    /**
     * @param int   $questionId
     * @param Pager $pager
     *
     * @return array
     */
    public function votesById(int $questionId, Pager $pager): array;
}
