<?php
/*------------------------------------------------------------------------
 # SM Categories - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_Categories_Helper_Data extends Mage_Core_Helper_Abstract {
	public function __construct(){
		$this->defaults = array(
			/* General setting */
			'isenabled'		=> '1',									// show
			'title' 		=> 'SM Categories',
			/* Module options */
			'module_width' 		=> '650',								// width_module
			'theme' 			=> 'theme1',				
			
			/* category query */
			'product_category' 		=> array(),						// catsid
			'category_columns'		=> '2',
			'limit_sub_category'	=> '5',	
			
			/* category details*/
			'category_image_disp'			=> '1',					// show_image		
			'category_image_linkable'		=> '1',					// link_image		
			'category_image_width'			=> '300',				// thumb_width
			'category_image_height'			=> '300',				// thumb_height	

			'category_sub_image_disp'			=> '1',				// show_small_image		
			'category_sub_image_linkable'		=> '1',				// link_sub_image		
			'category_sub_image_width'			=> '300',			// sub_thumb_width
			'category_sub_image_height'			=> '300',			// sub_thumb_height			
			
			'category_title_disp'			=> '1',					// show_title
			'category_title_linkable'		=> '1',					// link_title
			'category_title_color'			=> '#000000',			// title_color
			'category_title_max_characters'	=> '15',				// limit_title
			
			'category_sub_title_disp'			=> '1',				// show_sub_title
			'category_sub_title_linkable'		=> '1',				// link_sub_title
			'category_sub_title_color'			=> '#000000',		// sub_title_color
			'category_sub_title_max_characters'	=> '15',			// limit_sub_title	

			'show_total_articles'					=> '1',
			'tab_event'								=> 'click',
			'product_links_target'					=> '_self',		// target
		
			/* advance setting*/
			'include_jquery'	=> '1',
			'pretext'			=> '',
			'posttext'			=> ''
			
			/**config_fields**/
		);
	}

	function get($attributes=array())
	{
		$data = $this->defaults;
		$general 					= Mage::getStoreConfig("categories_cfg/general");
		$module_setting				= Mage::getStoreConfig("categories_cfg/module_setting");
		$product_selection 			= Mage::getStoreConfig("categories_cfg/product_selection");
		$product_display_setting 	= Mage::getStoreConfig("categories_cfg/product_display_setting");
		$advanced 					= Mage::getStoreConfig("categories_cfg/advanced");
		if (!is_array($attributes)) {
			$attributes = array($attributes);
		}
		if (is_array($general))					$data = array_merge($data, $general);
		if (is_array($module_setting)) 			$data = array_merge($data, $module_setting);
		if (is_array($product_selection)) 		$data = array_merge($data, $product_selection);
		if (is_array($product_display_setting)) $data = array_merge($data, $product_display_setting);
		if (is_array($advanced)) 				$data = array_merge($data, $advanced);
		
		return array_merge($data, $attributes);;
	}
}
?>