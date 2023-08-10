<?php
/**
 * @copyright Copyright (c) 2023 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Helper\Page as PageHelper;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Widget\Block\BlockInterface;

/** Block responsible for displaying CMS Page List widget */
class PageList extends Template implements BlockInterface, OptionSourceInterface
{
    /**
     * @var string
     */
    protected $_template = "page-list.phtml";

    /**
     * @var PageRepositoryInterface
     */
    protected PageRepositoryInterface $cmsPages;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteria;

    /**
     * @var PageHelper
     */
    protected PageHelper $cmsHelper;

    /**
     * @var array|PageInterface[]
     */
    protected array $pages;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PageHelper $cmsHelper
     * @param Context $context
     * @param array $data
     * @throws LocalizedException
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PageHelper $cmsHelper,
        Context $context,
        array $data = [],
    ) {
        parent::__construct($context, $data);
        $this->cmsPages = $pageRepository;
        $this->_searchCriteria = $searchCriteriaBuilder;
        $this->cmsHelper = $cmsHelper;
        $this->pages = $this->cmsPages->getList($this->_searchCriteria->addFilter('is_active', 1)->create())->getItems();
    }


    /**
     * Send options to multiselect field
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->pages as $page)
        {
            $options[] = [
                'value' => $page->getId(),
                'label' => $page->getTitle(),
            ];
        }

        return $options;
    }

    /**
     * Get title and url of required pages for template
     *
     * @return array
     * @throws LocalizedException
     */
    public function getPages(): array
    {
        $data = [];

        $displayMode = $this->getData("display_mode");

        if($displayMode === "all")
        {
            /** @var PageInterface $page */
            foreach ($this->pages as $page)
            {
                $data[$page->getTitle()] = $this->cmsHelper->getPageUrl($page->getId());
            }
        }

        if($displayMode === "specific")
        {
            $selectedPageIds = explode(",", $this->getData("selected_pages"));

            foreach ($selectedPageIds as $id)
            {
                $page = $this->cmsPages->getById($id);

                $data[$page->getTitle()] = $this->cmsHelper->getPageUrl($id);
            }
        }

        return $data;
    }
}
