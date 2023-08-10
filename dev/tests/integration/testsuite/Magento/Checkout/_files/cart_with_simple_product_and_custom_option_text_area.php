<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

use Magento\Catalog\Api\Data\ProductCustomOptionInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Option;
use Magento\Checkout\Model\Session;
use Magento\Framework\DataObject;
use Magento\Quote\Model\Quote;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\Workaround\Override\Fixture\Resolver;

Resolver::getInstance()->requireDataFixture('Magento/Catalog/_files/product_simple_with_custom_option_text_area.php');

/** @var ProductRepositoryInterface $productRepository */
$productRepository = Bootstrap::getObjectManager()
    ->create(ProductRepositoryInterface::class);
$product = $productRepository->get('simple_with_custom_option_text_area');

$options = [];
/** @var $option Option */
foreach ($product->getOptions() as $option) {
    switch ($option->getGroupByType()) {
        case ProductCustomOptionInterface::OPTION_GROUP_SELECT:
            $value = key($option->getValues());
            break;
        default:
            $value = <<<EOT
            Xindex product simple with
custom option text area
with more 50 characters
EOT;
            break;
    }
    $options[$option->getId()] = $value;
}

$requestInfo = new DataObject(['qty' => 1, 'options' => $options]);

/** @var $cart \Magento\Checkout\Model\Cart */
$quote = Bootstrap::getObjectManager()->create(Quote::class);
$quote->setReservedOrderId('test_order_item_with_custom_option_text_area');
$quote->addProduct($product, $requestInfo);
$quote->save();

/** @var $objectManager \Magento\TestFramework\ObjectManager */
$objectManager = Bootstrap::getObjectManager();
$objectManager->removeSharedInstance(Session::class);
