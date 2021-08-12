<?php
namespace Amasty\FirstModule\Model;

use Magento\Framework\Model\AbstractModel;

class Blacklist extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(
            ResourceModel\Blacklist::class  // привязываем ресурсную модель
        );
    }
}

