<?php

use Mselyatin\Question\services\VoteService;

return [
    VoteService::class => \DI\autowire(VoteService::class)
];