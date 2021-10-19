<?php

namespace Js\CustomFields\Observer;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Js\CustomFields\Model\CustomAttributes;

/**
 * Class SalesOrderLoadAfter
 * @package Js\CustomFields\Observer
 */
class SalesOrderLoadAfter implements ObserverInterface
{

    /**
     * Add custom attributes to order api
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getOrder();
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->getOrderExtensionDependency();
        }
        $extensionAttributes->setData(CustomAttributes::SELLER_CODE,$order->getData(CustomAttributes::SELLER_CODE));
        $order->setExtensionAttributes($extensionAttributes);
    }

    private function getOrderExtensionDependency()
    {
        $orderExtension = ObjectManager::getInstance()->get('\Magento\Sales\Api\Data\OrderExtension');
        return $orderExtension;
    }
}
