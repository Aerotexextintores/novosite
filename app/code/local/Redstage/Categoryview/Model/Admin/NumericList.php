<?php
    class Redstage_Categoryview_Model_Admin_NumericList extends Mage_Core_Model_Config_Data
    {
        
     public function save()
        {
            $value = $this->getValue();
           
		    if($value){
			    $valArr = explode(',', $value);
			    foreach($valArr as $val){
			   		if(!is_numeric(trim($val)))
			        	Mage::throwException("Fields specifying 'Numeric' must have numeric values only!");
			    }
		    }
            $newVal = explode(',', trim($value));
			$this->setValue($newVal);
            return parent::save();
        }   
    }



?>