<?php
/*------------------------------------------------------------------------
 # SM Megashop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Megashop_Model_System_Config_Source_ListColor
{
	public function toOptionArray()
	{	
		return array(
		array('value'=>'default', 'label'=>Mage::helper('megashop')->__('Default')),
		array('value'=>'blue', 'label'=>Mage::helper('megashop')->__('Blue')),
		array('value'=>'orange', 'label'=>Mage::helper('megashop')->__('Orange')),
		array('value'=>'red', 'label'=>Mage::helper('megashop')->__('Red'))		
		);
	}
}
