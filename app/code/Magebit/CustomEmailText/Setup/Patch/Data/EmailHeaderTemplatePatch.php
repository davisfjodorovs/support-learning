<?php

declare(strict_types=1);

namespace Magebit\CustomEmailText\Setup\Patch\Data;

use Magento\Email\Model\ResourceModel\Template as TemplateResourceModel;
use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class EmailHeaderTemplatePatch implements DataPatchInterface
{
    /**
     * @var TemplateFactory
     */
    private TemplateFactory $templateFactory;

    /**
     * @var TemplateResourceModel
     */
    private TemplateResourceModel $templateResourceModel;

    /**
     * @param TemplateFactory $templateFactory
     * @param TemplateResourceModel $templateResourceModel
     */
    public function __construct(
        TemplateFactory       $templateFactory,
        TemplateResourceModel $templateResourceModel,
    )
    {
        $this->templateFactory = $templateFactory;
        $this->templateResourceModel = $templateResourceModel;
    }

    /**
     * @return void
     * @throws AlreadyExistsException
     */
    private function createEmailTemplate(): void
    {
        $template = $this->templateFactory->create();
        $template->setTemplateCode("Modified header");
        $template->setTemplateSubject("{{trans 'Modified Header'}}");
        $template->setTemplateType(2);
        $template->setTemplateText(file_get_contents(__DIR__ . "/../../../view/frontend/email/modifiedheader.html"));
        $template->setOrigTemplateCode("modified_header_template");
        $this->templateResourceModel->save($template);
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            EmailTextBlockPatch::class
        ];
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
     * @throws AlreadyExistsException
     */
    public function apply(): void
    {
        $this->createEmailTemplate();
    }
}
