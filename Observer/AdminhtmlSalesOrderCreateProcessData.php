<?php

namespace Js\CustomFields\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class AdminhtmlSalesOrderCreateProcessData
 * @package Js\CustomFields\Observer
 */
class AdminhtmlSalesOrderCreateProcessData implements ObserverInterface
{
    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        $requestData = $observer->getRequest();
        if (isset($requestData['seller_code'])) {
            $sellerCode =$requestData['seller_code'];
            /** @var \Magento\Sales\Model\AdminOrder\Create $orderCreateModel */
            $orderCreateModel = $observer->getOrderCreateModel();
            $quote = $orderCreateModel->getQuote();
            $quote->setSellerCode($sellerCode);
        }
        return $this;
    }
}
