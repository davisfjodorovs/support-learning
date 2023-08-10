<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Magento\Backend\App\Action;

class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
