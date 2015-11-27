<?php
/*------------------------------------------------------------------------
 # SM Category Slider - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Categoryslider_Model_System_Config_Source_ColumnSetting
{
	public function toOptionArray()
	{
		return array(
			array('value' => 1,			'label' => Mage::helper('categoryslider')->__('1')),
			array('value' => 2, 		'label' => Mage::helper('categoryslider')->__('2')),
			array('value' => 3,			'label' => Mage::helper('categoryslider')->__('3')),
			array('value' => 4, 		'label' => Mage::helper('categoryslider')->__('4'))
		);
	}
}
