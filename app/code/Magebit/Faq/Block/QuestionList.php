<?php

declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;

class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryInterface
     */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected SearchCriteriaBuilderFactory $searchCriteriaFactory;

    /**
     * @param Template\Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaFactory
     */
    public function __construct(
        Template\Context $context,
        QuestionRepositoryInterface $questionRepository,
        SearchCriteriaBuilderFactory $searchCriteriaFactory,
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        try {
            $questions = $this->questionRepository->getList($this->getSearchCriteria())->getItems();
            return $this->sortQuestions($questions);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param array $questions
     * @return array
     */
    protected function sortQuestions(array $questions): array
    {
        $callback = function (QuestionInterface $a, QuestionInterface $b) {
            if($a->getPosition() === $b->getPosition()) return 0;
            return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
        };
        usort($questions, $callback);
        return $questions;
    }

    /**
     * @return SearchCriteriaInterface
     */
    protected function getSearchCriteria(): SearchCriteriaInterface
    {
        $searchCriteriaBuilder = $this->searchCriteriaFactory->create();
        return $searchCriteriaBuilder->addFilter(
            "status",
            1,
            "eq"
        )->create();
    }
}
