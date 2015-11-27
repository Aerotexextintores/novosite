<?php
/*------------------------------------------------------------------------
 # SM Category Slider - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Categoryslider_Model_System_Config_Source_Effect
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'fall',				'label' => Mage::helper('categoryslider')->__('FALL')),
			array('value' => 'slide', 			    'label' => Mage::helper('categoryslider')->__('SLIDE')),
			array('value' => 'fallrotate',			'label' => Mage::helper('categoryslider')->__('ROTATE FALL')),
			array('value' => 'scalerotate', 		'label' => Mage::helper('categoryslider')->__('ROTATE SCALE')),
			array('value' => 'stackback',			'label' => Mage::helper('categoryslider')->__('STACK')),
			array('value' => '3dflip', 		        'label' => Mage::helper('categoryslider')->__('3D FLIP')),
			array('value' => 'bringback',		    'label' => Mage::helper('categoryslider')->__('BRING BACK')),
			array('value' => 'superscale',		    'label' => Mage::helper('categoryslider')->__('SUPERSCALE')),
			array('value' => 'flip',		        'label' => Mage::helper('categoryslider')->__('CENTER FLIP')),
			array('value' => 'frontrow',		    'label' => Mage::helper('categoryslider')->__('FRONT ROW')),

		);
	}
}
