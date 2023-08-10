<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultInterface;
use Magento\Framework\Api\SearchResults;

class QuestionSearchResult extends SearchResults implements QuestionSearchResultInterface
{
    /**
     * @return QuestionInterface[]
     */
    public function getItems(): array
    {
        return parent::getItems();
    }

    /**
     * @param array $items
     * @return QuestionSearchResultInterface
     */
    public function setItems(array $items): QuestionSearchResultInterface
    {
        return parent::setItems($items);
    }
}
