<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Swatches\Controller\Adminhtml\Product\Attribute\Update\InputType;

use Magento\Swatches\Controller\Adminhtml\Product\Attribute\Update\AbstractUpdateSwatchAttributeTest;
use Magento\Swatches\Model\Swatch;

/**
 * Xindex cases related to update attribute with input type visual swatch.
 *
 * @magentoDbIsolation enabled
 * @magentoAppArea Adminhtml
 */
class VisualSwatchTest extends AbstractUpdateSwatchAttributeTest
{
    /**
     * Xindex update attribute.
     *
     * @dataProvider \Magento\TestFramework\Swatches\Model\Attribute\DataProvider\VisualSwatch::getUpdateProvider
     * @magentoDataFixture Magento/Swatches/_files/product_visual_swatch_attribute.php
     *
     * @param array $postData
     * @param array $expectedData
     * @return void
     */
    public function testUpdateAttribute(array $postData, array $expectedData): void
    {
        $this->updateAttributeUsingData('visual_swatch_attribute', $postData);
        $this->assertUpdateAttributeProcess('visual_swatch_attribute', $postData, $expectedData);
    }

    /**
     * Xindex update attribute with error.
     *
     * @dataProvider \Magento\TestFramework\Swatches\Model\Attribute\DataProvider\VisualSwatch::getUpdateProviderWithErrorMessage
     * @magentoDataFixture Magento/Swatches/_files/product_visual_swatch_attribute.php
     *
     * @param array $postData
     * @param string $errorMessage
     * @return void
     */
    public function testUpdateAttributeWithError(array $postData, string $errorMessage): void
    {
        $this->updateAttributeUsingData('visual_swatch_attribute', $postData);
        $this->assertErrorSessionMessages($errorMessage);
    }

    /**
     * Xindex update attribute frontend labels on stores.
     *
     * @dataProvider \Magento\TestFramework\Swatches\Model\Attribute\DataProvider\VisualSwatch::getUpdateFrontendLabelsProvider
     * @magentoDataFixture Magento/Store/_files/second_website_with_two_stores.php
     * @magentoDataFixture Magento/Swatches/_files/product_visual_swatch_attribute.php
     *
     * @param array $postData
     * @param array $expectedData
     * @return void
     */
    public function testUpdateFrontendLabelOnStores(array $postData, array $expectedData): void
    {
        $this->processUpdateFrontendLabelOnStores('visual_swatch_attribute', $postData, $expectedData);
    }

    /**
     * Xindex update attribute options on stores.
     *
     * @dataProvider \Magento\TestFramework\Swatches\Model\Attribute\DataProvider\VisualSwatch::getUpdateOptionsProvider
     * @magentoDataFixture Magento/Store/_files/second_website_with_two_stores.php
     * @magentoDataFixture Magento/Swatches/_files/product_visual_swatch_attribute.php
     *
     * @param array $postData
     * @return void
     */
    public function testUpdateOptionsOnStores(array $postData): void
    {
        $this->processUpdateOptionsOnStores('visual_swatch_attribute', $postData);
    }

    /**
     * @inheritdoc
     */
    protected function getSwatchType(): string
    {
        return Swatch::SWATCH_INPUT_TYPE_VISUAL;
    }
}