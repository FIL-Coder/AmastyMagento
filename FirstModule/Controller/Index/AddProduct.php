<?php

namespace Amasty\FirstModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;


class AddProduct extends Action
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $get = $this->getRequest()->getParams();

        try {
            $product = $this->productRepository->get($get['sku']);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/magento2/firstmodule/');

            return $resultRedirect;
        }

        $quote = $this->checkoutSession->getQuote();

        if (!$quote->getId()) {
            $quote->save();
        }

        if ($product->getTypeId() == 'simple') {
            try {
                $quote->addProduct($product, $get['qty']);
                $quote->save();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl('/magento2/firstmodule/');

                return $resultRedirect;
            }

            $this->messageManager->addSuccessMessage($product->getName() . ' added to cart!');
        } else {
            $this->messageManager->addErrorMessage('This product is ' . $product->getTypeId() . '. We can add just simple product!');
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/magento2/firstmodule/');

        return $resultRedirect;
    }
}
