<?php
namespace Amasty\SecondModule\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;

class AddIdParam {
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var RequestInterface
     */
    protected $_request;

    public function __construct(
        RequestInterface $request,
        ProductRepositoryInterface $productRepository
    ) {
        $this->_request = $request;
        $this->productRepository = $productRepository;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function beforeExecute(
        $subject
    ) {

        $postData = $this->getRequest()->getParams();

        try {
            $product = $this->productRepository->get($postData['sku-search']);

            return $this->getRequest()->setPostValue('product', $product->getEntityId());
        } catch (\Exception $e) {
            return $e;
        }
    }
}
