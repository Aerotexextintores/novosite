<?php
/*------------------------------------------------------------------------
 # SM Categories - Version 1.0
 # Copyright (c) 2009-2011 YouTech Company. All Rights Reserved.
 # @license - Copyrighted Commercial Software
 # Author: YouTech Company
 # Websites: http://www.smartaddons.com
-------------------------------------------------------------------------*/

class Smartaddons_Categories_Block_List extends Mage_Core_Block_Template
{
	protected $_config = null;
	protected $_storeId = null;
	protected $_productCollection = null;
	protected $_category = null;
	
	public function __construct($attributes = array()){
		parent::__construct();
		$this->_config = Mage::helper('categories/data')->get($attributes);
	}

	public function getConfig($name=null, $value=null){
		if (is_null($this->_config)){
			$this->_config = Mage::helper('categories/data')->get(null);
		}
		if (!is_null($name) && !empty($name)){
			$valueRet = isset($this->_config[$name]) ? $this->_config[$name] : $value;
			return $valueRet;
		}
		return $this->_config;
	}
	
	public function setConfig($name, $value=null){
		if (is_null($this->_config)) $this->getConfig();
		if (is_array($name)){
			$this->_config = array_merge($this->_config, $name);
			return;
		}
		if (!empty($name)){
			$this->_config[$name] = $value;
		}
		return true;
	}
	
	protected function _toHtml(){
		$template = $this->getConfig('theme', 'theme1');
		//$template_file = "smartaddons/categories/block_template_default.phtml";
		$template_file = "smartaddons/categories/".$this->_config['theme'].".phtml";;
		$this->setTemplate($template_file);
		return parent::_toHtml();
	}
	
	public function getStoreId(){
		if (is_null($this->_storeId)){
			$this->_storeId = Mage::app()->getStore()->getId();
		}
		return $this->_storeId;
	}
	public function setStoreId($storeId=null){
		$this->_storeId = $storeId;
	}
	public function getCategory(){
		if (Mage::registry('current_category')){
			// is category view page.
			$current_category = Mage::registry('current_category');
			$current_category_id = $current_category->getId();
			//$product_ids = $current_category->getProductCollection()->getAllIds();
			//$collection->addIdFilter($product_ids);
			$category_ids = array();
			
			$cat_child_collection = Mage::getModel('catalog/category')->getCollection();
			$cat_child_collection ->addAttributeToSelect('*');
			$cat_child_collection ->addIsActiveFilter();			$cat_child_collection ->addAttributeToSort('position');
			if (count(explode(',',$current_category->getChildren()))>0){
				$cat_child_collection->addIdFilter(explode(',',$current_category->getChildren()));
			}
			$_catChild = array();
			//$_listCats = array();			
			$i = 0;
			
			foreach ($cat_child_collection as $catChild){
				if($i < $this->_config['limit_sub_category'] OR !$this->_config['limit_sub_category']){
					$i++;
					$childId = $catChild->getId();
					$_catChild[$childId] = array(
												'category_id' 			=> $childId,
												'category_name'			=> Mage::helper('core/string')->truncate( $catChild->getName(), $this->_config['category_sub_title_max_characters'],'...'),
												'category_description'	=> $catChild->getDescription(), 
												'category_link' 		=> $catChild->getUrl(),
												'category_thumb'		=> ($this->_config['category_sub_image_disp'])?$this->_getResizedImage($catChild,$this->_config['category_sub_image_width'],$this->_config['category_sub_image_height'],100):'',//$image_category,
												'products'				=> count($catChild->getProductCollection()->getAllIds()),
												'childs'				=> array()
											);				
				//$_listCats[]= $_catChild[$childId];
				}
			}			
			$this->_category[$current_category_id] =array(
										'category_id' 			=> $current_category_id,
										'category_name'			=> Mage::helper('core/string')->truncate( $current_category->getName(), $this->_config['category_title_max_characters'],'...'),
										'category_description'	=> $current_category->getDescription(),
										'category_link' 		=> $current_category->getUrl(),
										'category_thumb'		=> ($this->_config['category_image_disp'])?$this->_getResizedImage($current_category,$this->_config['category_image_width'],$this->_config['category_image_height'],100):'',//$image_category,
										'childIDs'				=> $current_category->getChildren(),
										'childs'				=> $_catChild									
									);	
		} else {
			// if Mage::registry('product') - is product page or another page.
			$category_ids = preg_split("/[,\s\D]+/", $this->_config['product_category']);
			if (is_array($category_ids)){
				foreach ($category_ids as $i => $id) {
					if (!is_numeric($id)){
						unset($category_ids[$i]);
					}
				}
			}
		}
		if (isset($category_ids) && count($category_ids)>0) $this->_addCategoryFilter2($category_ids);		
		
		return $this->_category;
	}	
	public function getConfigObject(){
		return $this->_config;
	//	return (object)$this->getConfig();
	}
	
	public function getScriptTags(){
		$import_str = "";
		$jsHelper = Mage::helper('core/js');
		if (null == Mage::registry('jsmart.jquery')){
			// jquery has not added yet
			if (Mage::getStoreConfigFlag('categories_cfg/advanced/include_jquery')){
				// if module allowed jquery.
				$import_str .= $jsHelper->includeSkinScript('smartaddons/categories/js/jquery-1.5.min.js');
				Mage::register('jsmart.jquery', 1);
			}
		}
		if (null == Mage::registry('jsmart.jquerynoconfict')){
			// add once noConflict
			$import_str .= $jsHelper->includeSkinScript('smartaddons/categories/js/jsmart.noconflict.js');
			Mage::register('jsmart.jquerynoconfict', 1);
		}
		
		if (null == Mage::registry('jsmart.categories.js')){
			// add script for this module.
			$import_str .= $jsHelper->includeSkinScript('smartaddons/categories/js/jquery.hoveraccordion.js');
			
			Mage::register('jsmart.categories.js', 1);
		}
		return $import_str;
	}
	
	private function _addCategoryFilter2($category_ids){
		$category_collection = Mage::getModel('catalog/category')->getCollection();
		$category_collection->addAttributeToSelect('*');
		$category_collection->addIsActiveFilter();		$category_collection ->addAttributeToSort('position');
		if (count($category_ids)>0){
			$category_collection->addIdFilter($category_ids);
		}
		$category_collection->getSelect()->group('entity_id');
		//$category_products = array();
		$this->_category = array();

		foreach ($category_collection as $category){
			$cid = $category->getId();
			//$childId = $category->getChildren();
			$cat_child_collection = Mage::getModel('catalog/category')->getCollection();
			$cat_child_collection ->addAttributeToSelect('*');
			$cat_child_collection ->addIsActiveFilter();			$cat_child_collection ->addAttributeToSort('position');
			if (count(explode(',',$category->getChildren()))>0){
				$cat_child_collection->addIdFilter(explode(',',$category->getChildren()));
			}
			$_catChild = array();
			//$_listCats = array();	
			$i=0;
			foreach ($cat_child_collection as $catChild){
				if($i < $this->_config['limit_sub_category'] OR !$this->_config['limit_sub_category']){
					$i++;
					$childId = $catChild->getId();
					$_catChild[$childId] = array(
												'category_id' 			=> $childId,
												'category_name'			=> Mage::helper('core/string')->truncate( $catChild->getName(), $this->_config['category_sub_title_max_characters'],'...'),
												'category_description'	=> $catChild->getDescription(), 
												'category_link' 		=> $catChild->getUrl(),
												'category_thumb'		=> ($this->_config['category_sub_image_disp'])?$this->_getResizedImage($catChild,$this->_config['category_sub_image_width'],$this->_config['category_sub_image_height'],100):'',//$image_category,
												'products'				=> count($catChild->getProductCollection()->getAllIds()),
												'childs'				=> array()
											);				
				//$_listCats[]= $_catChild[$childId];
				}
			}
			//if (!array_key_exists( $cid, $category_products)){
			//$category_products[$cid] = $category->getProductCollection()->getAllIds();
			//$image_category = (file_exists($category->getImageUrl()))?$category->getImageUrl():$this->getSkinUrl('smartaddons/categoryshowcase/images/no_image.gif');
			$this->_category[$cid] =array(
										'category_id' 			=> $cid,
										'category_name'			=> Mage::helper('core/string')->truncate( $category->getName(), $this->_config['category_title_max_characters'],'...'),
										'category_description'	=> $category->getDescription(), 
										'category_link' 		=> $category->getUrl(),
										'category_thumb'		=> ($this->_config['category_image_disp'])?$this->_getResizedImage($category,$this->_config['category_image_width'],$this->_config['category_image_height'],100):'',//$image_category,
										'childIDs'				=> $category->getChildren(),
										'childs'				=> $_catChild
									);
		//}			
		}
		
		//$product_ids = array();
		// if (count($category_products)){
			// foreach ($category_products as $cp) {
				// $product_ids = array_merge($product_ids, $cp);
			// }
		// }
		//$collection->addIdFilter($product_ids);
	}	

	private function _getResizedImage($catObj, $width, $height, $quality = 100) {	       
        if (! $catObj->getImage ())
			$imageUrl = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "category" . DS ."no_image.gif";
        else
			$imageUrl = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "category" . DS . $catObj->getImage ();
        if (! is_file ( $imageUrl ))
            return false;
		$file = pathinfo($imageUrl);
		//Zend_Debug::dump($file);die;	
        $imageName = $file['filename']."_".$width."x".$height.".".$file['extension'];
        $imageResized = Mage::getBaseDir ( 'media' ) . DS . "catalog" . DS . "product" . DS . "cache" . DS . "cat_resized" . DS . $imageName;// Because clean Image cache function works in this folder only
       	if (!file_exists ( $imageResized ) && file_exists ( $imageUrl ) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) {
            $imageObj = new Varien_Image ( $imageUrl );
            $imageObj->constrainOnly ( false );
            $imageObj->keepAspectRatio ( false );
            $imageObj->keepFrame ( false );
            $imageObj->quality ( $quality );
            $imageObj->resize ( $width, $height );
            $imageObj->save ( $imageResized );
        }
        
        if(file_exists($imageResized)){
            return Mage::getBaseUrl ( 'media' ) ."/catalog/product/cache/cat_resized/" . $imageName;
        }elseif(file_exists($catObj->getImageUrl())){
			return $catObj->getImageUrl();
		}else{
            return $this->getSkinUrl('smartaddons/categories/images/no_image.gif');
        }
    }	
}
