<?php

namespace AnkitDev\RequestInvoice\Model;

class RequestInvoice extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    
    protected function _construct()
    {
        $this->_init('AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice');
    }

}