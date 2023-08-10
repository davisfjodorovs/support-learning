<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

/**
 * Question listing index controller
 */
class Index implements HttpGetActionInterface
{
    /**
     * @var ResultFactory
     */
    protected ResultFactory $resultFactory;

    /**
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ResultFactory $resultFactory,
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @inheritDoc
     * @return Page
     */
    public function execute(): Page
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->getConfig()->getTitle()->set(__("Frequently Asked Questions"));
        return $page;
    }
}
