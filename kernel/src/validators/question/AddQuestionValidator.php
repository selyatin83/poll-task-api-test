<?php

namespace Mselyatin\Question\validators\question;

use Mselyatin\Question\core\factory\ErrorFactory;
use Mselyatin\Question\dto\QuestionDto;
use Mselyatin\Question\exceptions\ClientErrorException;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

/**
 * @author <selyatin83@mail.ru>
 */
class AddQuestionValidator
{
    /**
     * @param QuestionDto $questionDto
     *
     * @return bool
     * @throws ClientErrorException
     */
    public function validate(QuestionDto $questionDto): bool
    {
        try {
            $validator = v::attribute('question', v::stringType()->length(10, 5000)->notBlank())
                        ->attribute('answers', v::arrayType()->notBlank());

            $validator->assert($questionDto);
            return true;
        } catch (NestedValidationException $e) {
            throw new ClientErrorException(
                ErrorFactory::VALIDATION_ERROR,
                extra: $e->getMessages()
            );
        }
    }
}
