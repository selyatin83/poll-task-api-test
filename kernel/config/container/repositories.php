<?php

use Mselyatin\Question\repositories\interfaces\QuestionRepositoryInterface;
use Mselyatin\Question\repositories\interfaces\VoteRepositoryInterface;
use Mselyatin\Question\repositories\SqlQuestionRepository;
use Mselyatin\Question\repositories\SqlVoteRepository;

return [
    QuestionRepositoryInterface::class => \DI\autowire(SqlQuestionRepository::class),
    VoteRepositoryInterface::class => \DI\autowire(SqlVoteRepository::class)
];