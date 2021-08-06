<?php
namespace Amasty\SecondModule\Plugin;

class ChangeUrl {
    public function afterGetFormAction(
        $subject,
        $result
    ) {
        $result = '/magento2/checkout/cart/add';
        return $result;
    }
}

