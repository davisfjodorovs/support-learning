<?php

declare(strict_types=1);

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;

/**
 * Question management interface
 *
 * @api
 */
interface QuestionManagementInterface
{
    /**
     * Enable a question
     *
     * @param QuestionInterface $question
     * @return Questioninterface
     */
    public function enableQuestion(QuestionInterface $question): Data\QuestionInterface;

    /**
     * Disable a question
     *
     * @param QuestionInterface $question
     * @return Questioninterface
     */
    public function disableQuestion(QuestionInterface $question): Data\QuestionInterface;
}
