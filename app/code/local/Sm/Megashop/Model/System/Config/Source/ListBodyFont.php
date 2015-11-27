<?php
/*------------------------------------------------------------------------
 # SM Megashop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Megashop_Model_System_Config_Source_ListBodyFont
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'Arial', 'label'=>Mage::helper('megashop')->__('Arial')),
			array('value'=>'Arial Black', 'label'=>Mage::helper('megashop')->__('Arial-black')),
			array('value'=>'Courier New', 'label'=>Mage::helper('megashop')->__('Courier New')),
			array('value'=>'Georgia', 'label'=>Mage::helper('megashop')->__('Georgia')),
			array('value'=>'Impact', 'label'=>Mage::helper('megashop')->__('Impact')),
			array('value'=>'Lucida Console', 'label'=>Mage::helper('megashop')->__('Lucida-console')),
			array('value'=>'Lucida Grande', 'label'=>Mage::helper('megashop')->__('Lucida-grande')),
			array('value'=>'Palatino', 'label'=>Mage::helper('megashop')->__('Palatino')),
			array('value'=>'Tahoma', 'label'=>Mage::helper('megashop')->__('Tahoma')),
			array('value'=>'Times New Roman', 'label'=>Mage::helper('megashop')->__('Times New Roman')),	
			array('value'=>'Trebuchet', 'label'=>Mage::helper('megashop')->__('Trebuchet')),	
			array('value'=>'Verdana', 'label'=>Mage::helper('megashop')->__('Verdana'))		
		);
	}
}
