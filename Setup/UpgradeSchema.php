<?php

namespace Js\CustomFields\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Sales\Setup\SalesSetup;
use Js\CustomFields\Model\CustomAttributes;

/**
 * Class UpgradeSchema
 * @package Js\CustomFields\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * @var \Magento\Sales\Setup\SalesSetupFactory
     */
    protected $_salesSetupFactory;

    /**
     * UpgradeSchema constructor.
     * @param \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
     */
    public function __construct(
     \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
    ){
        $this->_salesSetupFactory = $salesSetupFactory;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        // if (version_compare($context->getVersion(), '1.0.1', '<')) {
        //     $connection->changeColumn($setup->getTable('sales_order'), 'offer_code', 'offer_code', [
        //         'type'     => Table::TYPE_INTEGER,
        //         'nullable' => true,
        //         'length'   => 11,
        //         'comment'  => 'Offer Code'
        //     ]);
        // }

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            /** @var SalesSetup $salesSetup */
            $salesSetup = $this->_salesSetupFactory->create();
            $salesSetup->addAttribute('order', CustomAttributes::SELLER_CODE, ['type' =>'varchar']);

            $setup->getConnection()->addColumn(
                $setup->getTable('sales_order_grid'),
                CustomAttributes::SELLER_CODE,
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Seller Code'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('quote'),
                CustomAttributes::SELLER_CODE,
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Seller Code'
                ]
            );
        }

        $setup->endSetup();
    }
}
