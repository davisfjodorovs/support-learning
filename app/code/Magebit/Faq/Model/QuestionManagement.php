<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionManagementInterface;

class QuestionManagement implements QuestionManagementInterface
{
    /**
     * Enables passed question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function enableQuestion(QuestionInterface $question): QuestionInterface
    {
        return $question->setStatus(Question::STATUS_ENABLED);
    }

    /**
     * Disables passed question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function disableQuestion(QuestionInterface $question): QuestionInterface
    {
        return $question->setStatus(Question::STATUS_DISABLED);
    }
}
