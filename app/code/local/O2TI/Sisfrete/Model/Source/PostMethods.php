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

class O2TI_Sisfrete_Model_Source_PostMethods
{

    public function toOptionArray()
    {
        return array(
            array('value'=>6376926, 'label'=>Mage::helper('adminhtml')->__('Sisfrete Pac (6376926)')),
            array('value'=>6376927, 'label'=>Mage::helper('adminhtml')->__('BRASPRESS (6376927)')),
            array('value'=>6376921, 'label'=>Mage::helper('adminhtml')->__('JADLOG RODO (6376921)')),
            array('value'=>6376925, 'label'=>Mage::helper('adminhtml')->__('JADLOG.COM (6376925)')),
            array('value'=>6376920, 'label'=>Mage::helper('adminhtml')->__('JADLOG PACKAGE (6376920)')),
            array('value'=>6376923, 'label'=>Mage::helper('adminhtml')->__('JADLOG ECONOMICO (6376923)')),
            array('value'=>6376922, 'label'=>Mage::helper('adminhtml')->__('JADLOG CARGO (6376922)')),
            array('value'=>6376924, 'label'=>Mage::helper('adminhtml')->__('Bla bla (6376924)')),
        );
    }

}
