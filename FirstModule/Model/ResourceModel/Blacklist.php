<?php
namespace Amasty\FirstModule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blacklist extends AbstractDb
{
    protected function _construct()   // это НЕ конструктор. Это просто метод с именем _construct
    {
        $this->_init(
            'amasty_firstmodule_blacklist', // таблица, из которой будут браться данные
            'product_id'      // колонка, которая хранит id записей
        );
    }
}
