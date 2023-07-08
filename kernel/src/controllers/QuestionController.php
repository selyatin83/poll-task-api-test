<?php

namespace Mselyatin\Question\controllers;

use Mselyatin\Question\core\factory\ErrorFactory;
use Mselyatin\Question\core\Kernel;
use Mselyatin\Question\dto\QuestionDto;
use Mselyatin\Question\dto\VoteDto;
use Mselyatin\Question\exceptions\ClientErrorException;
use Mselyatin\Question\repositories\interfaces\QuestionRepositoryInterface;
use Mselyatin\Question\services\Pager;
use Mselyatin\Question\services\VoteService;
use Mselyatin\Question\validators\question\AddQuestionValidator;
use Mselyatin\Question\validators\vote\AddVoteValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author <selyatin83@mail.ru>
 */
class QuestionController extends BaseController
{
    /** @var QuestionRepositoryInterface  */
    private QuestionRepositoryInterface $questionRepository;

    /** @var VoteService  */
    private VoteService $voteService;

    public function __construct()
    {
        parent::__construct();
        $this->questionRepository = Kernel::$container->get(QuestionRepositoryInterface::class);
        $this->voteService = Kernel::$container->get(VoteService::class);
    }

    /**
     * Creating a new question
     *
     * @throws ClientErrorException
     */
    public function create(): JsonResponse
    {
        $data = $this->request->getContent();
        /** @var QuestionDto $questionDto */
        $questionDto = $this->deserialize($data, QuestionDto::class);

        $validator = new AddQuestionValidator();
        $validator->validate($questionDto);

        $id = $this->questionRepository->add($questionDto);
        return new JsonResponse([
            'id' => $id
        ]);
    }

    /**
     * To vote
     *
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function vote(): JsonResponse
    {
        $data = $this->request->getContent();
        /** @var QuestionDto $questionDto */
        $voteDto = $this->deserialize($data, VoteDto::class);

        $validator = new AddVoteValidator();
        $validator->validate($voteDto);

        $this->voteService->vote($voteDto);
        return new JsonResponse([]);
    }

    /**
     * Returning a list votes of question
     *
     * @return JsonResponse
     * @throws ClientErrorException
     */
    public function votes(): JsonResponse
    {
        $data = $this->request->query->all();

        $pager = Pager::create(
            $data['page'] ?? null,
            $data['limit'] ?? null
        );

        $id = $data['id'] ?? null;
        if (null === $id) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "The question ID doesn`t exist"
            );
        }

        if (!$this->questionRepository->isQuestionExistById($id)) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                "The question doesn`t exist"
            );
        }

        $list = $this->questionRepository->votesById((int) $id, $pager);
        return new JsonResponse($list);
    }
}
