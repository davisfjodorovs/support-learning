<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultInterface;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magebit\Faq\Api\Data\QuestionSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var QuestionResourceModel
     */
    protected QuestionResourceModel $resource;

    /**
     * @var QuestionFactory
     */
    protected QuestionFactory $modelFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected QuestionCollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var QuestionSearchResultInterfaceFactory
     */
    protected QuestionSearchResultInterfaceFactory $searchResultsFactory;

    /**
     * @param QuestionResourceModel $resource
     * @param QuestionCollectionFactory $collectionFactory
     * @param QuestionFactory $modelFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuestionSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        QuestionResourceModel $resource,
        QuestionCollectionFactory $collectionFactory,
        QuestionFactory $modelFactory,
        CollectionProcessorInterface $collectionProcessor,
        QuestionSearchResultInterfaceFactory $searchResultsFactory,
    ) {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        $this->resource->save($question);
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $questionId): Question
    {
        $question = $this->modelFactory->create();
        $this->resource->load($question, $questionId);
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(QuestionInterface $question): bool
    {
        return (bool)$this->resource->delete($question);
    }

    /**
     * @param int $questionId
     * @return bool
     * @throws \Exception
     */
    public function deleteById(int $questionId): bool
    {
        $question = $this->modelFactory->create();
        $this->resource->load($question, $questionId);
        return (bool)$this->resource->delete($question);
    }
}
