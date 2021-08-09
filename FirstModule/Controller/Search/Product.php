<?php

namespace Amasty\FirstModule\Controller\Search;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Product extends Action
{
    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var JsonFactory
     */
    protected $jsonResultFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        JsonFactory $jsonResultFactory
    ) {
        $this->jsonResultFactory = $jsonResultFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $search_text = $this->getRequest()->getParam('e', false );

//        $search_text = '24-MB0';

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name')->addAttributeToFilter('sku',
           ['like' => '%'.$search_text.'%']
        );

        $data = [];
        foreach ($collection as $product) {
            $data[] = ['sku' => $product->getSku(), 'name' => $product->getName()];
        }

        $result = $this->jsonResultFactory->create();
        $result->setData($data);
        return $result;
    }
}
