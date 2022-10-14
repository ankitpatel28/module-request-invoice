<?php

namespace AnkitDev\RequestInvoice\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class RequestInvoice extends Action {
/**
 * @var PageFactory
 */
private $pageFactory;


/**
 * Index constructor.
 * @param Context $context
 * @param PageFactory $pageFactory
 */
public function __construct(
    Context $context,
    PageFactory $pageFactory
)
{
    parent::__construct($context);
    $this->pageFactory = $pageFactory;
}

public function execute()
{
    $page = $this->pageFactory->create();
    return $page;
}
}
?>
