<?php
/**
 * O2TI Soluções Web Ltda.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the New BSD License.
 * It is also available through the world-wide-web at this URL:
 * http://www.o2ti.com/new-bsd-license/
 *
 * @category   O2TI
 * @package    O2TI_Sisfrete
 * @copyright  Copyright (c) 2011 O2TI Soluções Web Ltda. (http://www.o2ti.com)
 * @author     O2TI Soluções Web Ltda. <contato@o2ti.com>
 * @license    http://www.o2ti.com/new-bsd-license/ New BSD License
 */

$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$installer->deleteConfigData('carriers/O2TI_Sisfrete/urlmethod');

$sql = "select value from ".$installer->getTable('core/config_data')." where path='carriers/O2TI_Sisfrete/postmethods'";
$methods = explode(',', $connection->fetchOne($sql));
foreach($methods as $key => $method){
    if($method == '41025'){
        unset($methods[$key]);
    }
}
if(count($methods) <= 0){
    $methods[] = '41106';
}
$installer->setConfigData('carriers/O2TI_Sisfrete/postmethods', implode(',', $methods));

$sql = "select value from ".$installer->getTable('core/config_data')." where path='carriers/O2TI_Sisfrete/free_method'";
if($connection->fetchOne($sql) == '41025'){
    $installer->setConfigData('carriers/O2TI_Sisfrete/free_method', '41106');
}

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->updateAttribute('catalog_product', 'volume_comprimento', 'note', 'Comprimento da embalagem do produto (Para cálculo dos Sisfrete)');
$setup->updateAttribute('catalog_product', 'volume_altura', 'note', 'Altura da embalagem do produto (Para cálculo dos Sisfrete)');
$setup->updateAttribute('catalog_product', 'volume_largura', 'note', 'Largura da embalagem do produto (Para cálculo dos Sisfrete)');

$installer->endSetup();
