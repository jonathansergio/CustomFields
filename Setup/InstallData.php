<?php

namespace Js\CustomFields\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Js\CustomFields\Model\CustomAttributes;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // if (version_compare($context->getVersion(), '1.0.0') < 0){

        //     $salesSetup = $objectManager->create('Magento\Sales\Setup\SalesSetup');

        //     $salesSetup->addAttribute('order', 'offer_token', ['type' =>'varchar']);
        //     $salesSetup->addAttribute('order', 'offer_code', ['type' =>'varchar']);
        //     $salesSetup->addAttribute('order', 'carrier_name', ['type' =>'varchar']);
        //     $salesSetup->addAttribute('order', 'carrier_service', ['type' =>'varchar']);

        // }

        if (version_compare($context->getVersion(), '1.0.2') < 0){

            $salesSetup = $objectManager->create('Magento\Sales\Setup\SalesSetup');
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

    }
}
