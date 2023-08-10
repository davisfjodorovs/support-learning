<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Backend\Block;

/**
 * Xindex class for \Magento\Backend\Block\Template.
 *
 * @magentoAppArea Adminhtml
 */
class TemplateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Backend\Block\Template
     */
    protected $_block;

    protected function setUp(): void
    {
        parent::setUp();
        $this->_block = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(
            \Magento\Framework\View\LayoutInterface::class
        )->createBlock(
            \Magento\Backend\Block\Template::class
        );
    }

    /**
     * @covers \Magento\Backend\Block\Template::getFormKey
     */
    public function testGetFormKey()
    {
        $this->assertGreaterThan(15, strlen($this->_block->getFormKey()));
    }

    /**
     * @magentoAppArea Adminhtml
     * @covers \Magento\Backend\Block\Template::isOutputEnabled
     * @magentoConfigFixture current_store advanced/modules_disable_output/dummy 1
     */
    public function testIsOutputEnabledTrue()
    {
        $this->_block->setData('module_name', 'dummy');
        $this->assertFalse($this->_block->isOutputEnabled('dummy'));
    }

    /**
     * @magentoAppArea Adminhtml
     * @covers \Magento\Backend\Block\Template::isOutputEnabled
     * @magentoConfigFixture current_store advanced/modules_disable_output/dummy 0
     */
    public function testIsOutputEnabledFalse()
    {
        $this->_block->setData('module_name', 'dummy');
        $this->assertTrue($this->_block->isOutputEnabled('dummy'));
    }
}