<?php

declare(strict_types=1);

namespace Magebit\PreFooterText\Block;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PreFooterText extends Template
{
    /**
     * @var PageInterface
     */
    private PageInterface $page;

    /**
     * @param Context $context
     * @param PageInterface $page
     * @param array $data
     */
    public function __construct(
        Context $context,
        PageInterface $page,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->page = $page;
    }

    /**
     * @return string|null
     */
    public function getPreFooterText(): string|null
    {
        return $this->page->getData("pre_footer_text");
    }
}
