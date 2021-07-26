<?php

namespace Amasty\FirstModule\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;

class Form extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function enabledQty()
    {
        return $this->scopeConfig->isSetFlag('first_config/general/show_qty');
    }

    public function getDefaultQty()
    {
        return $this->scopeConfig->getValue('first_config/general/default_qty');
    }

    public function getFormAction()
    {
        return $this->getUrl('firstmodule/index/addproduct');
    }
}
