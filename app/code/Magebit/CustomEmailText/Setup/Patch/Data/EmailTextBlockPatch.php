<?php

declare(strict_types=1);

namespace Magebit\CustomEmailText\Setup\Patch\Data;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class EmailTextBlockPatch implements DataPatchInterface
{
    /**
     * @var BlockInterfaceFactory
     */
    private BlockInterfaceFactory $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private BlockRepositoryInterface $blockRepository;

    /**
     * @param BlockInterfaceFactory $blockFactory
     * @param BlockRepositoryInterface $blockRepository
     */
    public function __construct(
        BlockInterfaceFactory    $blockFactory,
        BlockRepositoryInterface $blockRepository,
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    private function createBlock(): void
    {
        $newBlock = $this->blockFactory->create();
        $newBlock->setTitle("Custom email header content");
        $newBlock->setIdentifier("custom_email_header_content");
        $newBlock->setContent(file_get_contents(__DIR__ . "/../../Content/blocktemplate.html"));
        $this->blockRepository->save($newBlock);
    }

    /**
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->createBlock();
    }

    /**
     * @return array|string[]
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
