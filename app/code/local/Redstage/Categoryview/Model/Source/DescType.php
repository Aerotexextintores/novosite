<?php
	class Redstage_Categoryview_Model_Source_DescType{
		public function toOptionArray(){
			return array(
				array('value' => 'long', 'label' => 'Long'),
				array('value' => 'short', 'label' => 'Short')
			);
		}
	}
?>