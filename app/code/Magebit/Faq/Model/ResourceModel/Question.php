<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Question extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var bool
     */
    protected $_useIsObjectNew = true;

    /**
     * @param Context $context
     * @param $connectionName
     */
    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init("faq", QuestionInterface::ID);
    }
}
