<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebit\Faq\Model\Question as QuestionModel;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(QuestionModel::class, QuestionResourceModel::class);
    }
}
