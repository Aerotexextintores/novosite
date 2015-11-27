<?php
/*------------------------------------------------------------------------
 # SM Megashop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Megashop_Model_System_Config_Source_ListBgPosition
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'left top', 'label'=>Mage::helper('megashop')->__('left top')),
			array('value'=>'left top', 'label'=>Mage::helper('megashop')->__('left top')),
			array('value'=>'left bottom', 'label'=>Mage::helper('megashop')->__('left bottom')),
			array('value'=>'right top', 'label'=>Mage::helper('megashop')->__('right top')),
			array('value'=>'right center', 'label'=>Mage::helper('megashop')->__('right center')),
			array('value'=>'right bottom', 'label'=>Mage::helper('megashop')->__('right bottom')),
			array('value'=>'center top', 'label'=>Mage::helper('megashop')->__('center top')),
			array('value'=>'center center', 'label'=>Mage::helper('megashop')->__('center center')),
			array('value'=>'center bottom', 'label'=>Mage::helper('megashop')->__('center bottom'))
		);
	}
}
