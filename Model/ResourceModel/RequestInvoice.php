<?php

namespace AnkitDev\RequestInvoice\Model\ResourceModel;

class RequestInvoice extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $storeManager;
    
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->storeManager = $storeManager;
    }
    
    protected function _construct()
    {
        $this->_init('ankitdev_request_invoice', 'request_id');
    }
}