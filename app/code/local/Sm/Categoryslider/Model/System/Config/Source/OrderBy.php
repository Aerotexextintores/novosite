<?php
/*------------------------------------------------------------------------
 # SM Category Slider - Version 1.0.0
 # Copyright (c) 2014 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Categoryslider_Model_System_Config_Source_OrderBy
{
	public function toOptionArray()
	{
		return array(
			array('value'	=> 	'name', 			'label' => Mage::helper('categoryslider')->__('Name')),
			array('value'	=> 	'entity_id',		'label' => Mage::helper('categoryslider')->__('Id')),
			//array('value'	=> 	'position',		'label' => Mage::helper('categoryslider')->__('Position')),
			array('value'	=> 	'created_at', 		'label' => Mage::helper('categoryslider')->__('Date Created')),
			array('value'	=> 	'price', 			'label' => Mage::helper('categoryslider')->__('Price')),
			array('value'	=> 	'lastest_product', 	'label' => Mage::helper('categoryslider')->__('Lastest Product')),
			array('value'	=> 	'top_rating', 		'label' => Mage::helper('categoryslider')->__('Top Rating')),
			array('value'	=> 	'most_reviewed',	'label' => Mage::helper('categoryslider')->__('Most Reviews')),
			array('value'	=> 	'most_viewed',		'label' => Mage::helper('categoryslider')->__('Most Viewed')),
			array('value'	=> 	'best_sales',		'label' => Mage::helper('categoryslider')->__('Most Selling')),
			array('value'	=> 	'random', 			'label' => Mage::helper('categoryslider')->__('Random')),
		);
	}
}
