<?php

namespace Js\CustomFields\Observer;

use Magento\Framework\DataObject\Copy;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SaveOrderBeforeSalesModelQuoteObserver
 * @package Js\CustomFields\Observer
 */
class SaveOrderBeforeSalesModelQuoteObserver implements ObserverInterface
{

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this|void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getData('quote');

        if ($quote->getSellerCode()) {
            /* @var \Magento\Sales\Model\Order $order */
            $order = $observer->getEvent()->getData('order');
            $order->setSellerCode($quote->getSellerCode());
        }
        return $this;
    }
}

