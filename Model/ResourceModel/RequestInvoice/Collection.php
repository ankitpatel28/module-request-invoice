<?php
namespace AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice;
 
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
 
    protected $_idFieldName = 'request_id';
     
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AnkitDev\RequestInvoice\Model\RequestInvoice', 'AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice');
    }
 
}