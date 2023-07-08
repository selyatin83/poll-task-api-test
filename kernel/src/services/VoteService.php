<?php

namespace Mselyatin\Question\services;

use Mselyatin\Question\core\factory\ErrorFactory;
use Mselyatin\Question\dto\AddVoteDto;
use Mselyatin\Question\dto\VoteDto;
use Mselyatin\Question\exceptions\ClientErrorException;
use Mselyatin\Question\repositories\interfaces\QuestionRepositoryInterface;
use Mselyatin\Question\repositories\interfaces\VoteRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author <selyatin83@mail.ru>
 */
class VoteService
{
    /** @var QuestionRepositoryInterface  */
    private QuestionRepositoryInterface $questionRepository;

    /** @var VoteRepositoryInterface  */
    private VoteRepositoryInterface $voteRepository;

    /** @var Request  */
    private Request $request;

    /**
     * @param QuestionRepositoryInterface $questionRepository
     * @param VoteRepositoryInterface     $voteRepository
     * @param Request                     $request
     */
    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        VoteRepositoryInterface $voteRepository,
        Request $request
    ) {
        $this->questionRepository = $questionRepository;
        $this->voteRepository = $voteRepository;
        $this->request = $request;
    }

    /**
     * @param VoteDto $voteDto
     *
     * @return void
     * @throws ClientErrorException
     */
    public function vote(VoteDto $voteDto): void
    {
        $question = $this->questionRepository->getById($voteDto->question_id);
        if ($question === null) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "The question doesn`t exist"
            );
        }

        $isExistAnswer = $this->questionRepository->isAnswerExist($voteDto->question_id, $voteDto->answer);
        if (false === $isExistAnswer) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "The answer doesn`t exist in this question"
            );
        }

        $userIp = $this->request->getClientIp();
        if (null === $userIp) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "The user IP address doesn`t exist"
            );
        }

        $addVoteDto = AddVoteDto::create(
            $voteDto->user_name,
            $voteDto->answer,
            $voteDto->question_id,
            $userIp
        );

        if ($this->voteRepository->isExistVoteByIp($addVoteDto->question_id, $addVoteDto->userIp)) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "You already voted"
            );
        }

        if (false === $this->voteRepository->add($addVoteDto)) {
            throw new ClientErrorException(
                ErrorFactory::SYSTEM_ERROR,
                "The unknown error, try later, please"
            );
        }
    }
}