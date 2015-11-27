<?php 
    class Redstage_Categoryview_Model_Category extends Mage_Catalog_Model_Category
    {
       public function isDisplaySub($currentCategory, &$listSubs)
       {
            $listSubs = false;
            
            $rootCat = $this->getStore()->getRootCategoryId();
                        
            $catList = array();
            if(Mage::getStoreConfig('categoryview/display/toplevel')){
                $topChildren = $this->load($rootCat)->getChildrenCategories();
                
                foreach($topChildren as $topChild)
                    array_push($catList, $topChild->getId());
				
				if(in_array($currentCategory, $catList) && Mage::getStoreConfig('categoryview/display/subcats'))
					$listSubs = true;
            }
			
			if(Mage::getStoreConfig('categoryview/display/thirdcat_beyond_level')){
				$topChildren = $this->load($rootCat)->getChildrenCategories();
				$all_children = $this->getResource()->getAllChildren(Mage::getModel('catalog/category')->load($rootCat));
				
				foreach($topChildren as $child)
					unset($all_children[array_search($child->getId(), $all_children)]);
				
				$catList = array_merge($catList, $all_children);
				
				if(in_array($currentCategory, $all_children) && Mage::getStoreConfig('categoryview/display/thirdcat_beyond_subcats'))
					$listSubs = true;
            }
                        
            $data = $this->load($currentCategory)->getData();
            if($data['subcategoryview'])
                array_push($catList, $data['subcategoryview']);
            
            return in_array($currentCategory, $catList);
       }

    }




?>