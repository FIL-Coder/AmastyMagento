<?php

namespace Amasty\SecondModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session as CustomerSession;

class Index extends Action
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->customerSession->isLoggedIn()) {
            if ($this->scopeConfig->isSetFlag('first_config/general/enabled')) {
                return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            } else {
                die('Module is disabled! If you want to see this page, please enable the module ;-)');
            }
        } else {
            die('You need to login!');
        }
    }
}
