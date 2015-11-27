<?php
    class Redstage_Categoryview_Block_Category extends Mage_Catalog_Block_Category_View {
            
            public function getCategoryStatus(){
                return Mage::getStoreConfig('categoryview/settings/enabled');
            }
            
            public function getViewType(){
                return Mage::getStoreConfig('categoryview/appearance/viewtype');
            }
            
            public function getGridColumnCount(){
                return Mage::getStoreConfig('categoryview/appearance/colcount');
            }
            
            public function getImageStatus(){
                return Mage::getStoreConfig('categoryview/appearance/picture');
            }
            
            public function getImageType(){
                return Mage::getStoreConfig('categoryview/appearance/pictype');
            }
            
            public function getNamePosition(){
                return Mage::getStoreConfig('categoryview/appearance/namepos');
            }
            
            public function getDisplaySub(){
                return Mage::getStoreConfig('categoryview/display/subcats');
            }
            
            public function getSubListLimit(){
                return Mage::getStoreConfig('categoryview/display/sublimit');
            }
            
            public function getDescriptionStatus(){
                return Mage::getStoreConfig('categoryview/appearance/desc');
            }
            
            public function getThumbnailImageUrl($category){
                $url = false;
                if ($image = $category->getThumbnail()) {
                    $url = Mage::getBaseUrl('media').'catalog/category/'.$image;
                }
                return "$url";
            }

            public function getImageWidth(){
                return Mage::getStoreConfig('categoryview/styles/img_w');
            }

            public function getImageHeight(){
                if(Mage::getStoreConfig('categoryview/styles/img_h'))
                    return Mage::getStoreConfig('categoryview/styles/img_h');
                else 
                    return $this->getImageWidth();
            }

            public function getRightContWidth(){
                return Mage::getStoreConfig('categoryview/styles/rightcont');
            }
    }
    
?>
        