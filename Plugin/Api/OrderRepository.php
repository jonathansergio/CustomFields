<?php

namespace Js\CustomFields\Plugin\Api;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Js\CustomFields\Model\CustomAttributes;
use Js\CustomFields\Model\CustomerApiData;

/**
 * Class OrderRepository
 * @package Js\CustomFields\Plugin\Api
 */
class OrderRepository
{

    /**
     * Order Extension Attributes Factory
     *
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * @var CustomerApiData
     */
    private $customerApiData;

    /**
     * OrderRepository constructor.
     * @param OrderExtensionFactory $extensionFactory
     * @param CustomerApiData $customerApiData
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory,
        CustomerApiData $customerApiData
    ) {
        $this->customerApiData = $customerApiData;
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Add custom attributes extension attribute to order data object to make it accessible in API data
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
        $extensionAttributes->setData(CustomAttributes::SELLER_CODE,$order->getData(CustomAttributes::SELLER_CODE));
        $extensionAttributes->setData(CustomAttributes::CUSTOMER_API_DATA, $this->customerApiData->getInformation($order));
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * Add "delivery_type" extension attribute to order data object to make it accessible in API data
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     *
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
            $extensionAttributes->setSellerCode($order->getData(CustomAttributes::SELLER_CODE));
            $extensionAttributes->setCustomerApiData($this->customerApiData->getInformation($order));
            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}
