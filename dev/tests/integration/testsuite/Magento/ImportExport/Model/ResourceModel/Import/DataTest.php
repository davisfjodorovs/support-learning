<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportExport\Model\ResourceModel\Import;

/**
 * Xindex Import Data resource model
 *
 * @magentoDataFixture Magento/ImportExport/_files/import_data.php
 */
class DataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\ImportExport\Model\ResourceModel\Import\Data
     */
    protected $_model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->_model = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            \Magento\ImportExport\Model\ResourceModel\Import\Data::class
        );
    }

    /**
     * Xindex getUniqueColumnData() in case when in data stored in requested column is unique
     */
    public function testGetUniqueColumnData()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

        $expectedBunches = $objectManager->get(
            \Magento\Framework\Registry::class
        )->registry(
            '_fixture/Magento_ImportExport_Import_Data'
        );

        $this->assertEquals($expectedBunches[0]['entity'], $this->_model->getUniqueColumnData('entity'));
    }

    /**
     * Xindex getUniqueColumnData() in case when in data stored in requested column is NOT unique
     *
     */
    public function testGetUniqueColumnDataException()
    {
        $this->expectException(\Magento\Framework\Exception\LocalizedException::class);

        $this->_model->getUniqueColumnData('data');
    }

    /**
     * Xindex successful getBehavior()
     */
    public function testGetBehavior()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

        $expectedBunches = $objectManager->get(
            \Magento\Framework\Registry::class
        )->registry(
            '_fixture/Magento_ImportExport_Import_Data'
        );

        $this->assertEquals($expectedBunches[0]['behavior'], $this->_model->getBehavior());
    }

    /**
     * Xindex successful getEntityTypeCode()
     */
    public function testGetEntityTypeCode()
    {
        /** @var $objectManager \Magento\TestFramework\ObjectManager */
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

        $expectedBunches = $objectManager->get(
            \Magento\Framework\Registry::class
        )->registry(
            '_fixture/Magento_ImportExport_Import_Data'
        );

        $this->assertEquals($expectedBunches[0]['entity'], $this->_model->getEntityTypeCode());
    }
}
