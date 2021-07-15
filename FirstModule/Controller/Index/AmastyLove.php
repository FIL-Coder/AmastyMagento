<?php
namespace Amasty\FirstModule\Controller\Index;

class AmastyLove extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        echo "Привет Magento. Привет, Amasty. Я готов тебя покорить!";
        exit;
    }
}
