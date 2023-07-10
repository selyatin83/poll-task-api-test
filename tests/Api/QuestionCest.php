<?php
namespace tests\Api;

use Tests\Support\ApiTester;

class QuestionCest
{
    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function createQuestionSuccessCest(ApiTester $I): void
    {
        $I->wantTo('Create a new question');
        $I->sendPost(
            '/question',
            json_encode([
                'question' => "Description test question",
                "answers" => [
                    "Answer_1",
                    "Answer_2",
                    "Answer_3",
                    "Answer_4",
                    "Answer_5",
                ]
            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('id');
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function createQuestionWithoutAnswersErrorCest(ApiTester $I): void
    {
        $I->wantTo('Create a new question without the answers');
        $I->sendPost(
            '/question',
            json_encode([
                'question' => "Description test question",
                "answers" => []
            ])
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'message' => 'Validation error',
            'extra' => [
                'answers' => 'answers must not be blank'
            ]
        ]);
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function createEmptyQuestionCest(ApiTester $I): void
    {
        $I->wantTo('Create a new empty question');
        $I->sendPost(
            '/question',
            json_encode([
                'question' => "",
                "answers" => [
                    "Answer_1",
                    "Answer_2",
                    "Answer_3",
                    "Answer_4",
                    "Answer_5",
                ]
            ])
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'message' => 'Validation error',
            'extra' => [
                'question' => 'question must not be blank'
            ]
        ]);
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function toVoteSuccessCest(ApiTester $I): void
    {
        $I->wantTo('To vote for the question');
        $I->sendPost(
            '/question/vote',
            json_encode([
                'question_id' => 1,
                "user_name" => 'test user name',
                "answer" => "Answer_1",
            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function toVoteAlreadyHasCest(ApiTester $I): void
    {
        $I->wantTo('To vote for the question, but vote already has');
        $I->sendPost(
            '/question/vote',
            json_encode([
                'question_id' => 1,
                "user_name" => 'test user name',
                "answer" => "Answer_1",
            ])
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'code' => 6,
            'message' => 'You already voted'
        ]);
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function questionVoteListSuccess(ApiTester $I): void
    {
        $I->wantTo('Get the votes of question');
        $I->sendGet(
            '/question/vote',
            [
                'id' => 1
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'answer' => 'Answer_1'
        ]);
    }

    /**
     * @param ApiTester $I
     *
     * @return void
     */
    public function questionVoteListWithoutId(ApiTester $I): void
    {
        $I->wantTo('Get the votes of question without the question id');
        $I->sendGet(
            '/question/vote'
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'code' => 6,
            'message' => 'The question ID doesn`t exist'
        ]);
    }
}
