<?php

declare(strict_types=1);

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Question repository interface
 *
 * @api
 */
interface QuestionRepositoryInterface
{
    /**
     * Save page.
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function save(QuestionInterface $question): Data\QuestionInterface;

    /**
     * Retrieve page.
     *
     * @param int $questionId
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function getById(int $questionId): Data\QuestionInterface;

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): Data\QuestionSearchResultInterface;

    /**
     * Delete page.
     *
     * @param QuestionInterface $question
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(QuestionInterface $question): bool;

    /**
     * Delete page by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $questionId): bool;
}
