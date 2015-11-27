<?php
/*------------------------------------------------------------------------
 # SM Categories - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/
class Smartaddons_Categories_Model_System_Config_Source_ListJsEvent
{
	public function toOptionArray()
	{
		return array(
		array('value'=>'', 'label'=>Mage::helper('categories')->__('-Select Event-')),
		array('value'=>'click', 'label'=>Mage::helper('categories')->__('Mouse Click')),
		array('value'=>'hover', 'label'=>Mage::helper('categories')->__('Mouse Hover'))
		);
	}
}
