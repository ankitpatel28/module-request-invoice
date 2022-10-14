<?php

namespace AnkitDev\RequestInvoice\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use AnkitDev\RequestInvoice\Model\RequestInvoiceFactory;
use AnkitDev\RequestInvoice\Helper\Email;
use Magento\Sales\Model\OrderFactory;
use Psr\Log\LoggerInterface;

class Post extends Action
{
    /** 
     * @var Magento\Framework\Controller\Result\JsonFactory 
    */ 
    protected $resultJsonFactory;

    /** 
     * @var \AnkitDev\RequestInvoice\Model\RequestInvoiceFactory
    */
    protected $requestInvoiceFactory;

    /** 
     * @var \AnkitDev\RequestInvoice\Helper\Email
    */
    private $helperEmail;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        RequestInvoiceFactory $requestInvoiceFactory,
        JsonFactory $resultJsonFactory,
        OrderFactory $orderFactory,
        Email $helperEmail,
        LoggerInterface $logger
    ) {
        $this->requestInvoiceFactory = $requestInvoiceFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderFactory = $orderFactory;
        $this->helperEmail = $helperEmail;
        $this->logger = $logger;
        parent::__construct($context);
    }   
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPostValue();
            if ($data) {
                $model = $this->requestInvoiceFactory->create();
                $orderModel = $this->orderFactory->create();
                $order = $orderModel->loadByIncrementId($data['order_id']);
                if(count($order->getData()) && $order->getCustomerEmail() == $data['email_customer']) {
                    // Save data to database
                    $data['status'] = 'disapprove';
                    $model->setData($data)->save();
                    // Assign values for your template variables
                    $emailTemplateVariables = $data;

                    // Mail send
                    $this->helperEmail->sendEmailToAdmin($emailTemplateVariables);
                    $this->helperEmail->sendMailToCustomer($emailTemplateVariables);
                    $this->messageManager->addSuccessMessage(__("Thank you for your message! We will contact you shortly."));
                }
                elseif(count($order->getData()) == 0) {
                    $this->messageManager->addErrorMessage(__("Please enter valid Order ID."));
                    $this->logger->error('Please enter valid Order ID.');
                }
                else {
                    $this->messageManager->addErrorMessage(__("Please enter valid customer email address."));
                    $this->logger->error('Please enter valid customer email address.');
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
            $this->logger->error($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath(
                    'requestpost/index/requestinvoice', ['_secure'=>$this->getRequest()->isSecure()]
                );
             
    }
}