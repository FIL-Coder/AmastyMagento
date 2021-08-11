<?php

namespace Amasty\FirstModule\Model;

use Amasty\FirstModule\Model\BlacklistFactory;
use Amasty\FirstModule\Model\ResourceModel\Blacklist;

class BlacklistRepository
{
    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var Blacklist
     */
    private $blacklistResource;

    public function __construct(
        BlacklistFactory $blacklistFactory,
        Blacklist $blacklistResource
    ) {
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
    }

    public function getById($id) {
        $value = $this->blacklistFactory->create();
        $this->blacklistResource->load($value, $id);

        return $value;
    }

    public function deleteById($id) {
        $value = $this->getById($id);
        $this->blacklistResource->delete($value);
    }
}
