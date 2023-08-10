<?php

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;

class MassEnable extends Action implements HttpPostActionInterface
{
    /**
     * @var QuestionManagementInterface
     */
    protected QuestionManagementInterface $questionManagement;

    /**
     * @var QuestionRepositoryInterface
     */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @param Context $context
     * @param QuestionManagementInterface $questionManagement
     * @param QuestionRepositoryInterface $questionRepository
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        QuestionManagementInterface $questionManagement,
        QuestionRepositoryInterface $questionRepository,
        Filter $filter,
        CollectionFactory $collectionFactory,
    ) {
        parent::__construct($context);
        $this->questionManagement = $questionManagement;
        $this->questionRepository = $questionRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $question) {
            $this->questionManagement->enableQuestion($question);
            $this->questionRepository->save($question);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been enabled.', $collection->getSize())
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
