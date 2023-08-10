<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index implements ActionInterface
{
    /**
     * @var ResultFactory
     */
    protected ResultFactory $resultFactory;

    /**
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $page->getConfig()->getTitle()->set(__("Frequently Asked Questions"));
        return $page;
    }
}
