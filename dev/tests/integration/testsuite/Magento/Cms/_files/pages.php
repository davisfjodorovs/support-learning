<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();

/**
 * @var $page Page
 * @var $pageRepository PageRepositoryInterface
 */
$page = $objectManager->create(Page::class);
$pageRepository = $objectManager->create(PageRepositoryInterface::class);

$page->setTitle('Cms ExampleViewModel 100')
    ->setIdentifier('page100')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms ExampleViewModel 100 Title</h1>')
    ->setContentHeading('<h2>Cms ExampleViewModel 100 Title</h2>')
    ->setMetaTitle('Cms Meta title for page100')
    ->setMetaKeywords('Cms Meta Keywords for page100')
    ->setMetaDescription('Cms Meta Description for page100')
    ->setPageLayout('1column');
$pageRepository->save($page);

$page = $objectManager->create(Page::class);
$page->setTitle('Cms ExampleViewModel Design Blank')
    ->setIdentifier('page_design_blank')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms ExampleViewModel Design Blank Title</h1>')
    ->setContentHeading('<h2>Cms ExampleViewModel Blank Title</h2>')
    ->setMetaTitle('Cms Meta title for Blank page')
    ->setMetaKeywords('Cms Meta Keywords for Blank page')
    ->setMetaDescription('Cms Meta Description for Blank page')
    ->setPageLayout('1column')
    ->setCustomTheme('Magento/blank');
$pageRepository->save($page);
