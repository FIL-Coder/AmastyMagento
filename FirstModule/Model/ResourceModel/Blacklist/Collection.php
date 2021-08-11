<?php

namespace Amasty\FirstModule\Model\ResourceModel\Blacklist;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amasty\FirstModule\Model\Blacklist;
use Amasty\FirstModule\Model\ResourceModel\Blacklist as BlacklistResource;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            Blacklist::class,
            BlacklistResource::class
        );
    }
}
