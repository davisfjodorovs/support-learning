<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var QuestionFactory
     */
    protected QuestionFactory $questionFactory;

    /**
     * @var QuestionRepositoryInterface
     */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context $context
     * @param QuestionFactory $questionFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionFactory $questionFactory,
        QuestionRepositoryInterface $questionRepository,
    ) {
        parent::__construct($context);
        $this->questionFactory = $questionFactory;
        $this->questionRepository = $questionRepository;
    }


    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $model = $this->questionFactory->create();
            // Check if editing
            if ($this->getRequest()->getParam('id')) {
                $model = $this->questionRepository->getById((int)$this->getRequest()->getParam('id'));
            }
            $params = $this->getRequest()->getParams();
            $model->setData($params);
            $model = $this->questionRepository->save($model);
            // Check if successfully saved
            if ($model->getId()) {
                $this->messageManager->addSuccessMessage(__("Question Saved Successfully"));

                if($this->getRequest()->getParam("back", false)) {
                    return $resultRedirect->setPath('*/*/');
                }

                return $resultRedirect->setPath('*/*/edit/id/'.$model->getId());
            } else {
                throw new \Exception("Couldn't find the id of the question");
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something went wrong"));
            return $resultRedirect->setPath('*/*/edit');
        }
    }
}
