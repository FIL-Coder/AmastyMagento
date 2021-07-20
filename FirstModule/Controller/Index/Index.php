<?php
namespace Amasty\FirstModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        //echo “Это мой первый Action.”;
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
