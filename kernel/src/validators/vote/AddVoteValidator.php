<?php

namespace Mselyatin\Question\validators\vote;

use Mselyatin\Question\core\factory\ErrorFactory;
use Mselyatin\Question\dto\VoteDto;
use Mselyatin\Question\exceptions\ClientErrorException;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

/**
 * @author <selyatin83@mail.ru>
 */
class AddVoteValidator
{
    /**
     * @param VoteDto $voteDto
     *
     * @return bool
     * @throws ClientErrorException
     */
    public function validate(VoteDto $voteDto): bool
    {
        try {
            $validator = v::attribute('user_name', v::stringType()->length(1, 50)->notBlank())
                ->attribute('question_id', v::intType()->notBlank())
                ->attribute('answer', v::stringType()->notBlank());

            $validator->assert($voteDto);
            return true;
        } catch (NestedValidationException $e) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                extra: $e->getMessages()
            );
        }
    }
}