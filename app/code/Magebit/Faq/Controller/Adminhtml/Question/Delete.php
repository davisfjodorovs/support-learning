<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\QuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Delete extends Action implements HttpGetActionInterface
{
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
        $this->questionRepository = $questionRepository;
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        // check if we know what should be deleted
        $id = (int)$this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                // init model and delete
                $this->questionRepository->deleteById($id);

                // display success message
                $this->messageManager->addSuccessMessage(__('The question has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/');
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('Something went wrong'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
