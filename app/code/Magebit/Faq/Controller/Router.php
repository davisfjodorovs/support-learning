<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    protected ActionFactory $actionFactory;

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $identifier = trim($request->getPathInfo(), '/');

        if (str_contains($identifier, 'faq')) {
            $request->setModuleName('faq');
            $request->setControllerName('index');
            $request->setActionName('index');

            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }
}
