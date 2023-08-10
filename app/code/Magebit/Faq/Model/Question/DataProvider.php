<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\Question;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProviderInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magebit\Faq\Model\ResourceModel\Question\Collection;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;

class DataProvider extends AbstractDataProvider implements DataProviderInterface
{
    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [],
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $result = [];
        /** @var Collection $collection */
        $collection = $this->collection->getItems();
        /** @var QuestionInterface $question */
        foreach ($collection as $question) {
            $result[$question->getId()] = $question->getData();
        }
        return $result;
    }
}
