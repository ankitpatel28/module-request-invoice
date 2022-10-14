<?php
namespace AnkitDev\RequestInvoice\Controller\Adminhtml\Index;

use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;
/**
 * MassStatus controller class
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var \AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice\CollectionFactory
     */
    protected $requestCollectionFactory;

    public $filter;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * MassStatus constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice\CollectionFactory $requestCollectionFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        \AnkitDev\RequestInvoice\Model\ResourceModel\RequestInvoice\CollectionFactory $requestCollectionFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        LoggerInterface $logger
    ) {
        $this->filter = $filter;
        $this->requestCollectionFactory = $requestCollectionFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Execute mass action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
                $status = $this->getRequest()->getParam('approval');
                $collection = $this->filter->getCollection($this->requestCollectionFactory->create());
                $count = 0;
                foreach ($collection as $model) {
                    $model->setStatus($status);
                    $model->save();
                    $count++;
                }
                $this->messageManager->addSuccess(__('A total of %1 record(s) have been updated.', $count));
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
                $this->logger->error($e->getMessage());
            }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('requestinvoice/index/listing');
    }
}
