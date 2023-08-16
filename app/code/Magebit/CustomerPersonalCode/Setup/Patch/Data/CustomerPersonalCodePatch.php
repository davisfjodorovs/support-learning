<?php

declare(strict_types=1);

namespace Magebit\CustomerPersonalCode\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Validator\ValidateException;

class CustomerPersonalCodePatch implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
     * @var Attribute
     */
    private Attribute $attributeResource;

    /**
     * @var Config
     */
    private Config $eavConfig;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $customerSetupFactory
     * @param Config $eavConfig
     * @param Attribute $attributeResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory          $customerSetupFactory,
        Config                   $eavConfig,
        Attribute                $attributeResource,
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $customerSetupFactory;
        $this->attributeResource = $attributeResource;
        $this->eavConfig = $eavConfig;
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws ValidateException
     * @throws AlreadyExistsException
     */
    public function apply(): void
    {
        $eavSetup = $this->eavSetupFactory->create(["setup" => $this->moduleDataSetup]);

        $eavSetup->addAttribute(Customer::ENTITY, "personal_code", [
            "type" => "varchar",
            "input" => "text",
            "label" => "Personal Code",
            "required" => true,
            "visible" => true,
            "user_defined" => true,
            "is_unique" => true,
            "position" => 10,
            "is_filterable_in_grid" => true,
            "is_visible_in_grid" => true,
            "system" => 0,
        ]);

        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            "Default",
            "personal_code",
        );

        $attribute = $this->eavConfig->getAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            "personal_code",
        );
        $attribute->setData("used_in_forms", [
            "adminhtml_checkout",
            "adminhtml_customer",
            "checkout_register",
            "customer_account_create",
            "customer_account_edit",
        ]);

        $this->attributeResource->save($attribute);
    }
}
