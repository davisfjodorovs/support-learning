<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface
{
    /**#@+
     * Block's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(QuestionResourceModel::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return intval(parent::getData(self::ID));
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return intval($this->getData(self::POSITION));
    }

    /**
     * @return string|null
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @param string $question
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer(string $answer): QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus(int $status): QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition(int $position): QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }
}
