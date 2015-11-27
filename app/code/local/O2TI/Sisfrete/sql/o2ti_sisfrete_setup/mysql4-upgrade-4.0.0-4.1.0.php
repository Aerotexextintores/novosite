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

// Delete unused or edited config data
$installer->deleteConfigData('carriers/O2TI_Sisfrete/ignorar_erro');
$installer->deleteConfigData('carriers/O2TI_Sisfrete/Sisfreteerror');
$installer->deleteConfigData('carriers/O2TI_Sisfrete/maxweighterror');
$installer->deleteConfigData('carriers/O2TI_Sisfrete/valueerror');
$installer->deleteConfigData('carriers/O2TI_Sisfrete/showmethod');

$installer->endSetup();
