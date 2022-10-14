<?php
namespace AnkitDev\RequestInvoice\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $context->getLogger();
    }

    public function sendEmailToAdmin($emailTemplateVariables)
    {
        //To Admin
        try {
            $this->inlineTranslation->suspend();
            $senderEmail = $emailTemplateVariables['email_customer'];
            $senderName  = $emailTemplateVariables['name_customer'];
            if($senderEmail) {
                $sender = [
                    'name' => $senderName,
                    'email' => $senderEmail,
                ];

                $transport = $this->transportBuilder
                    ->setTemplateIdentifier('request_invoice_template')
                    ->setTemplateOptions(
                        [
                            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars($emailTemplateVariables)
                    ->setFrom($sender)
                    ->addTo($this->scopeConfig->getValue('contact/email/recipient_email',ScopeInterface::SCOPE_STORE))
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function sendMailToCustomer($emailTemplateVariables) 
    {
        //To Customer
        try {
            $this->inlineTranslation->suspend();
            $senderEmail = $this->scopeConfig->getValue('contact/email/recipient_email',ScopeInterface::SCOPE_STORE);
            $senderName  = $this->scopeConfig->getValue('contact/email/sender_email_identity',ScopeInterface::SCOPE_STORE);
            if($senderEmail) {
                $sender = [
                    'name' => $senderName,
                    'email' => $senderEmail,
                ];

            }
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('customer_request_invoice_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom($sender)
                ->addTo($emailTemplateVariables['email_customer'])
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}