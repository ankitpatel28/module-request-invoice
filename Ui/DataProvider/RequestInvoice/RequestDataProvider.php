<?php
namespace AnkitDev\RequestInvoice\Ui\DataProvider\RequestInvoice;
use AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice\CollectionFactory;
use AnkitDev\RequestInvoice\Model\RequestInvoiceFactory;
use Magento\Backend\Model\Auth\Session;

class RequestDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \AnkitDev\RequestInvoice\Model\RequestInvoiceFactory
     */
    protected $requestInvoiceFactory;

    protected $authSession;

    protected $customerSession;

    public function __construct(
        CollectionFactory $collectionFactory,
        RequestInvoiceFactory $requestInvoiceFactory,
        Session $authSession,
        \Magento\Customer\Model\Session $customerSession,
                          $name,
                          $primaryFieldName,
                          $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->requestInvoiceFactory = $requestInvoiceFactory;
        $this->authSession = $authSession;
        $this->customerSession = $customerSession;
    }
    public function getData()
    {
        if($this->authSession->isLoggedIn()) {
            return $this->collection->addFieldToSelect('*');
        }
    }
}
