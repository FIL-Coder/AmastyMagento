<?php

namespace Amasty\FirstModule\Controller\Index;

use Amasty\FirstModule\Model\BlacklistFactory;
use Amasty\FirstModule\Model\ResourceModel\Blacklist;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Amasty\FirstModule\Model\BlacklistRepository;


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

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var Blacklist
     */
    private $blacklistResource;

    /**
     * @var BlacklistRepository
     */
    private $blacklistRepository;

    public function __construct(
        BlacklistRepository $blacklistRepository,
        EventManager $eventManager,
        Context $context,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager,
        BlacklistFactory $blacklistFactory,
        Blacklist $blacklistResource,
        array $data = []
    ) {
        $this->blacklistRepository = $blacklistRepository;
        $this->eventManager = $eventManager;
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        parent::__construct($context, $data);
    }

    public function execute()
    {
        $post = $this->getRequest()->getParams();

        $this->eventManager->dispatch(
            'amasty_firstmodule_check_addproduct',
            ['sku_to_check' => $post['sku-search']]
        );

        try {
            $product = $this->productRepository->get($post['sku-search']);
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

            $skuDb = $this->blacklistFactory->create();
            $this->blacklistResource->load(
                $skuDb,
                $post['sku-search'],
                'sku'
            );
                try {
                    if ($skuDb->getSku() && $post['qty'] <= $skuDb->getQty()) {
                        $quote->addProduct($product, $post['qty']);

                        $this->messageManager->addSuccessMessage($product->getName() . ' added to cart!');
                    } else if ($skuDb->getSku() && $post['qty'] >= $skuDb->getQty()) {
                        $quote->addProduct($product, $skuDb->getQty());

                        $this->messageManager->addErrorMessage($product->getName() . ' added to cart just ' . $skuDb->getQty() . ', because limit!');
                    } else {
                        $blacklist = $this->blacklistFactory->create();
                        $blacklist->setSku($post['sku-search']);
                        $blacklist->setQty(10);
                        $this->blacklistResource->save($blacklist);

                        $this->messageManager->addErrorMessage($product->getName() . ' not added to cart, because we need add him to DB, but now you can try again, we added him to Database for you ;-)');
                    }

                    $quote->save();
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());

                    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setUrl('/magento2/firstmodule/');

                    return $resultRedirect;
                }
        } else {
            $this->messageManager->addErrorMessage('This product is ' . $product->getTypeId() . '. We can add just simple product!');
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/magento2/firstmodule/');

        return $resultRedirect;
    }
}
