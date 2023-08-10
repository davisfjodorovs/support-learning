<?php

declare(strict_types=1);

namespace Magebit\PreFooterText\Block;

class PreFooterText extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Api\Data\PageInterface
     */
    private \Magento\Cms\Api\Data\PageInterface $page;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Cms\Api\Data\PageInterface $page
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Api\Data\PageInterface $page,
        array $data = []
    ) {
        \Magento\Framework\View\Element\Template::__construct($context, $data);
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
