<?php

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

/**
 * Question interface.
 *
 * @api
 */
interface QuestionInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID                       = 'id';
    const QUESTION                 = 'question';
    const ANSWER                   = 'answer';
    const STATUS                   = 'status';
    const POSITION                 = 'position';
    const UPDATE_TIME              = 'updated_at';
    /**#@-*/

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * Get question.
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Get answer.
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Get item status.
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get item position.
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Get update time.
     *
     * @return string|null
     */
    public function getUpdateTime(): ?string;

    /**
     * Set item question
     *
     * @param string $question
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface;

    /**
     * Set item answer
     *
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer(string $answer): QuestionInterface;

    /**
     * Set item status
     *
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus(int $status): QuestionInterface;

    /**
     * Set item position
     *
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition(int $position): QuestionInterface;
}
