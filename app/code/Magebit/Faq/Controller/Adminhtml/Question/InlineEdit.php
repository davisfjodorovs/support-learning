<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\App\Action\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $jsonFactory;

    /**
     * @var QuestionRepositoryInterface
     */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param QuestionRepositoryInterface $questionInterface
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        QuestionRepositoryInterface $questionInterface,
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->questionRepository = $questionInterface;
    }
    public function execute(): Json
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (count($postItems) == 0) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $entityId) {
                    /** load your model to update the data */
                    try {
                        $model = $this->questionRepository->getById($entityId);
                        $model->setData(array_merge($model->getData(), $postItems[$entityId]));
                        $this->questionRepository->save($model);
                    } catch (\Exception $e) {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
