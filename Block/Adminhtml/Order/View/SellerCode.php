<?php

namespace Js\CustomFields\Block\Adminhtml\Order\View;

use Magento\Sales\Block\Adminhtml\Order\AbstractOrder;
use Magento\Sales\Model\OrderFactory;
use Js\CustomFields\Model\CustomAttributes;

/**
 * Class SellerCode
 * @package Js\CustomFields\Block\Adminhtml\Order\View
 */
class SellerCode extends AbstractOrder
{

    /**
     * @var OrderFactory
     */
    private $orderFactory;

    /**
     * SellerCode constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Sales\Helper\Admin $adminHelper
     * @param OrderFactory $orderFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Helper\Admin $adminHelper,
        OrderFactory $orderFactory,
        array $data = []
    ) {
        $this->orderFactory = $orderFactory;
        parent::__construct($context, $registry, $adminHelper, $data);
    }

    /**
     * @return string|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerCode()
    {
        // return CustomAttributes::SELLER_CODE;
        return $this->getOrder()->getExtensionAttributes()->getSellerCode();
    }

    /**
     * Return order id from order increment Id
     * @return \Magento\Sales\Model\Order|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRelatedOrderId()
    {
        $relatedOrder = $this->orderFactory->create();
        try {
            return $relatedOrder->loadByIncrementId($this->getParentOrder());
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            return null;
        }
    }
}
