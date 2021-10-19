<?php

namespace Js\CustomFields\Plugin\Sales\Block\Adminhtml\Order\Create\Form;

/**
 * Class SellerCode
 * @package Js\CustomFields\Plugin\Sales\Block\Adminhtml\Order\Create\Form
 */
class SellerCode
{

    /**
     * Add field to form
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Form\Account $subject
     * @param $result
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterToHtml(
        \Magento\Sales\Block\Adminhtml\Order\Create\Form\Account $subject, $result
    ) {
        $orderAttributesForm = $subject->getLayout()->createBlock(
            'Js\CustomFields\Block\Adminhtml\Order\Create\Form\SellerCode'
        );
        $orderAttributesForm->setTemplate('Js_CustomFields::order/create/form/seller_code.phtml');
        $orderAttributesForm->setStore($subject->getStore());
        $orderAttributesFormHtml = $orderAttributesForm->toHtml();

        return $result . $orderAttributesFormHtml;
    }
}
