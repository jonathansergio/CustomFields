<?php

namespace Js\CustomFields\Block\Adminhtml\Order\Create\Form;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Block\Adminhtml\Order\Create\AbstractCreate;

/**
 * Class SellerCode
 * @package Js\CustomFields\Block\Adminhtml\Order\Create\Form
 */
class SellerCode extends AbstractCreate
{

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Sales\Model\AdminOrder\Create $orderCreate,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $data);
    }

    /**
     * Return header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Seller');
    }

    /**
     * @return mixed
     */
    public function getParentOrderForReorder()
    {
        if ($this->_sessionQuote->getQuote()->getParentOrder()) {
            return $this->_sessionQuote->getQuote()->getParentOrder();
        }
        return null;
    }

}
