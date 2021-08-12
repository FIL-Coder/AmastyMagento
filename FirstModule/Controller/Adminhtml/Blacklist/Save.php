<?php
namespace Amasty\FirstModule\Controller\Adminhtml\Blacklist;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Amasty\FirstModule\Model\ResourceModel\Blacklist as BlacklistResource;
use Amasty\FirstModule\Model\BlacklistFactory;

class Save extends Action
{
    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var BlacklistResource
     */
    private $blacklistResource;

    public function __construct(
        Context $context,
        BlacklistResource $blacklistResource,
        BlacklistFactory $blacklistFactory

    ) {
        parent::__construct($context);
        $this->blacklistResource = $blacklistResource;
        $this->blacklistFactory = $blacklistFactory;
    }
    public function execute()
    {
        if ($data = $this->getRequest()->getParams()) {
            $productId = $this->getRequest()->getParam('product_id');
        try {
            $item = $this->blacklistFactory->create();
            if ($productId) {
                $this->blacklistResource->load($item, $productId);
            }

            $item->addData($data);
            $this->blacklistResource->save($item);
            $this->messageManager->addSuccessMessage(__('Product saved.'));
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, $exception->getMessage());
        }
        }

        return $this->_redirect('*/*/index');
    }
}
