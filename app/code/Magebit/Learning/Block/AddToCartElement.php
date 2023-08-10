<?php
/**
 * @copyright Copyright (c) 2023 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\Learning\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Session;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\InventoryCatalog\Model\GetStockIdForCurrentWebsite;
use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;

/**
 * Block responsible for displaying/passing available stock of a product
 */
class AddToCartElement extends Template
{
    /**
     * @var ProductInterface
     */
    protected ProductInterface $product;

    /**
     * @var GetProductSalableQtyInterface
     */
    protected GetProductSalableQtyInterface $getProductStableQtyInterface;

    /**
     * @var GetStockIdForCurrentWebsite
     */
    protected GetStockIdForCurrentWebsite $getStockIdForCurrentWebsite;

    /**
     * @param Context $context
     * @param Session $catalogSession
     * @param ProductRepositoryInterface $productRepository
     * @param GetProductSalableQtyInterface $getProductStableQtyInterface
     * @param GetStockIdForCurrentWebsite $getStockIdForCurrentWebsite
     * @throws NoSuchEntityException
     */
    public function __construct(
        Context $context,
        Session $catalogSession,
        ProductRepositoryInterface $productRepository,
        GetProductSalableQtyInterface $getProductStableQtyInterface,
        GetStockIdForCurrentWebsite $getStockIdForCurrentWebsite,
    )
    {
        parent::__construct($context);
        $this->product = $productRepository->getById($catalogSession->getData('last_viewed_product_id'));
        $this->getProductStableQtyInterface = $getProductStableQtyInterface;
        $this->getStockIdForCurrentWebsite = $getStockIdForCurrentWebsite;

    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @return float
     * @throws InputException
     * @throws LocalizedException
     */
    public function getProductStock(): float
    {
        $stockId = $this->getStockIdForCurrentWebsite->execute();

        return $this->getProductStableQtyInterface->execute($this->getProduct()->getSku(), $stockId);
    }
}
