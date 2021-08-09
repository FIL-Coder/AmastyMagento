<?php
namespace Amasty\SecondModule\Observer;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CheckSameSkuObserver implements ObserverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        $productSku = $observer->getData('sku_to_check');

        $skuList = $this->scopeConfig->getValue('second_config/general/for_sku');
        $promoProduct = $this->scopeConfig->getValue('second_config/general/promo_sku');

        if (substr_count($skuList, $productSku)) {
            $promoProduct = $this->productRepository->get($promoProduct);
            $quote = $this->checkoutSession->getQuote();

            if (!$quote->getId()) {
                $quote->save();
            }

            $quote->addProduct($promoProduct, 1);
            $quote->save();
        }
    }
}
