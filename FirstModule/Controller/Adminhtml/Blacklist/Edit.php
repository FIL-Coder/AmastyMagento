<?php

namespace Amasty\FirstModule\Controller\Adminhtml\Blacklist;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Edit extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend('Edit');

        return $resultPage;
    }
}
