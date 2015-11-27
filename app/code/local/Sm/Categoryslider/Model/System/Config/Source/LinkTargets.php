<?php
/*------------------------------------------------------------------------
 # SM Category Slider - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Categoryslider_Model_System_Config_Source_LinkTargets
{
	public function toOptionArray()
	{
		return array(
			array('value'	=>		'_self',		'label'=>Mage::helper('categoryslider')->__('Same Window')),
        	array('value'	=>		'_blank',		'label'=>Mage::helper('categoryslider')->__('New Window')),
			array('value'	=>		'_windowopen',	'label'=>Mage::helper('categoryslider')->__('Popup Window'))
		);
	}
}
