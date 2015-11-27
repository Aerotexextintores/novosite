<?php
/*------------------------------------------------------------------------
 # SM Megashop - Version 1.0
 # Copyright (c) 2014 The YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.magentech.com
-------------------------------------------------------------------------*/

class Sm_Megashop_Model_System_Config_Source_ListGoogleFont
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'', 'label'=>Mage::helper('megashop')->__('No select')),
			array('value'=>'Roboto', 'label'=>Mage::helper('megashop')->__('Roboto')),
			array('value'=>'Anton', 'label'=>Mage::helper('megashop')->__('Anton')),
			array('value'=>'Questrial', 'label'=>Mage::helper('megashop')->__('Questrial')),
			array('value'=>'Kameron', 'label'=>Mage::helper('megashop')->__('Kameron')),
			array('value'=>'Oswald', 'label'=>Mage::helper('megashop')->__('Oswald')),
			array('value'=>'Open Sans', 'label'=>Mage::helper('megashop')->__('Open Sans')),
			array('value'=>'BenchNine', 'label'=>Mage::helper('megashop')->__('BenchNine')),
			array('value'=>'Droid Sans', 'label'=>Mage::helper('megashop')->__('Droid Sans')),
			array('value'=>'Droid Serif', 'label'=>Mage::helper('megashop')->__('Droid Serif')),
			array('value'=>'PT Sans', 'label'=>Mage::helper('megashop')->__('PT Sans')),
			array('value'=>'Vollkorn', 'label'=>Mage::helper('megashop')->__('Vollkorn')),
			array('value'=>'Ubuntu', 'label'=>Mage::helper('megashop')->__('Ubuntu')),
			array('value'=>'Neucha', 'label'=>Mage::helper('megashop')->__('Neucha')),
			array('value'=>'Cuprum', 'label'=>Mage::helper('megashop')->__('Cuprum'))	
		);
	}
}
