<?php
namespace Amasty\SecondModule\Plugin;

class ChangeUrl {
    public function aroundGetFormAction(
        $subject,
        callable $proceed
    ) {
        return '/magento2/checkout/cart/add';
    }
}

