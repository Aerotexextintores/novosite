<?php
    class Redstage_Categoryview_Model_Admin_Numeric extends Mage_Core_Model_Config_Data
    {
        
     public function save()
        {
            $value = $this->getValue();
           
		    if($value && !is_numeric($value)){
				Mage::throwException("Fields specifying 'Numeric' must have numeric values only!");
		    }
            
            return parent::save();
        }   
    }



?>