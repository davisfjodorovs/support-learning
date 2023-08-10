<?php

declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

/**
 * Interface for Collection search results.
 *
 * @api
 */
interface QuestionSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get question list.
     *
     * @return QuestionInterface[]
     */
    public function getItems(): array;

    /**
     * Set Collection list.
     *
     * @param QuestionInterface[] $items
     * @return QuestionSearchResultInterface
     */
    public function setItems(array $items): QuestionSearchResultInterface;
}
