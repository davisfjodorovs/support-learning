<?php

declare(strict_types=1);

namespace Magebit\SpecialProduct\Setup\Patch\Data;



use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Tax\Api\TaxClassRepositoryInterface;
use Magento\Tax\Api\TaxRateRepositoryInterface;
use Magento\Tax\Api\TaxRuleRepositoryInterface;
use Magento\Tax\Api\Data\TaxRuleInterfaceFactory;
use Magento\Tax\Api\Data\TaxRateInterfaceFactory;
use Magento\Tax\Api\Data\TaxClassInterfaceFactory;
use Magento\Tax\Api\Data\TaxRateInterface;
use Magento\Tax\Api\Data\TaxClassInterface;
use Magento\Tax\Model\ClassModel;


class GlobalTax implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var CountryInformationAcquirerInterface
     */
    private CountryInformationAcquirerInterface $countryInformation;

    /**
     * @var TaxRateInterfaceFactory
     */
    private TaxRateInterfaceFactory $taxRateFactory;

    /**
     * @var TaxRateRepositoryInterface
     */
    private TaxRateRepositoryInterface $taxRateRepository;

    /**
     * @var TaxRuleInterfaceFactory
     */
    private TaxRuleInterfaceFactory $taxRuleInterfaceFactory;

    /**
     * @var TaxRuleRepositoryInterface
     */
    private TaxRuleRepositoryInterface $taxRuleRepository;

    /**
     * @var TaxClassInterfaceFactory
     */
    private TaxClassInterfaceFactory $taxClassInterfaceFactory;

    /**
     * @var TaxClassRepositoryInterface
     */
    private TaxClassRepositoryInterface $taxClassRepository;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CountryInformationAcquirerInterface $countryInformation
     * @param TaxRateInterfaceFactory $taxRateFactory
     * @param TaxRateRepositoryInterface $taxRateRepository
     * @param TaxRuleInterfaceFactory $taxRuleInterfaceFactory
     * @param TaxRuleRepositoryInterface $taxRuleRepository
     * @param TaxClassInterfaceFactory $taxClassInterfaceFactory
     * @param TaxClassRepositoryInterface $taxClassRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ModuleDataSetupInterface            $moduleDataSetup,
        CountryInformationAcquirerInterface $countryInformation,
        TaxRateInterfaceFactory             $taxRateFactory,
        TaxRateRepositoryInterface          $taxRateRepository,
        TaxRuleInterfaceFactory             $taxRuleInterfaceFactory,
        TaxRuleRepositoryInterface          $taxRuleRepository,
        TaxClassInterfaceFactory            $taxClassInterfaceFactory,
        TaxClassRepositoryInterface         $taxClassRepository,
        SearchCriteriaBuilder               $searchCriteriaBuilder,
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->countryInformation = $countryInformation;
        $this->taxRateFactory = $taxRateFactory;
        $this->taxRateRepository = $taxRateRepository;
        $this->taxRuleInterfaceFactory = $taxRuleInterfaceFactory;
        $this->taxRuleRepository = $taxRuleRepository;
        $this->taxClassInterfaceFactory = $taxClassInterfaceFactory;
        $this->taxClassRepository = $taxClassRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @throws InputException
     */
    private function getCustomerTaxClassIds(): array
    {
        $customerTaxClassIds = [];
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(ClassModel::KEY_TYPE, ClassModel::TAX_CLASS_TYPE_CUSTOMER)->create();
        $items = $this->taxClassRepository->getList($searchCriteria)->getItems();
        foreach($items as $item) {
            $customerTaxClassIds[] = $item->getId();
        }
        return $customerTaxClassIds;
    }

    /**
     * @throws InputException
     * @throws LocalizedException
     */
    private function createTaxClass(): TaxClassInterface
    {
        $taxClass = $this->taxClassInterfaceFactory->create();
        $taxClass->setClassName("5 Global");
        $taxClass->setClassType(ClassModel::TAX_CLASS_TYPE_PRODUCT);
        $this->taxClassRepository->save($taxClass);
        return $taxClass;
    }

    /**
     * @param array $taxRateIds
     * @param array $taxClassIds
     * @param array $customerTaxClassIds
     * @return void
     * @throws InputException
     */
    private function createTaxRule(array $taxRateIds, array $taxClassIds, array $customerTaxClassIds): void
    {
        $taxRule = $this->taxRuleInterfaceFactory->create();
        $taxRule->setCode("5 GLOBAL");
        $taxRule->setTaxRateIds($taxRateIds);
        $taxRule->setProductTaxClassIds($taxClassIds);
        $taxRule->setCustomerTaxClassIds($customerTaxClassIds);
        $taxRule->setPriority(0);
        $taxRule->setCalculateSubtotal(false);
        $taxRule->setPriority(0);
        $this->taxRuleRepository->save($taxRule);
    }

    /**
     * @return array
     * @throws InputException
     */
    private function createGlobalTaxRates(): array
    {
        $countries = $this->countryInformation->getCountriesInfo();
        $taxRateIds = [];
        foreach ($countries as $country) {
            $countryId = $country->getId();
            $countryAbbreviation = $country->getTwoLetterAbbreviation();

            $newTaxRate = $this->createTaxRate($countryId, $countryAbbreviation);

            $newTaxRate = $this->taxRateRepository->save($newTaxRate);
            $taxRateIds[] = $newTaxRate->getId();
        }

        return $taxRateIds;
    }

    /**
     * Create tax rate
     *
     * @param string $countryId
     * @param string $countryAbbreviation
     * @return TaxRateInterface
     */
    private function createTaxRate(string $countryId, string $countryAbbreviation): TaxRateInterface
    {
        $taxRate = $this->taxRateFactory->create();
        $taxRate->setCode("5 GLOBAL " . $countryAbbreviation);
        $taxRate->setZipIsRange(0);
        $taxRate->setTaxPostcode("*");
        $taxRate->setRegionName("*");
        $taxRate->setTaxCountryId($countryId);
        $taxRate->setRate(5.0);

        return $taxRate;
    }

    /**
     * @return void
     * @throws InputException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $taxRateIds = $this->createGlobalTaxRates();
        $taxClassIds = [];
        $taxClassIds[] = $this->createTaxClass()->getClassId();
        $customerTaxClassIds = $this->getCustomerTaxClassIds();
        $this->createTaxRule($taxRateIds, $taxClassIds, $customerTaxClassIds);
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }


    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}
