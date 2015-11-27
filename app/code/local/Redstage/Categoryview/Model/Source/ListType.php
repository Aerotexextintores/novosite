<?php
	class Redstage_Categoryview_Model_Source_ListType{
		public function toOptionArray(){
			return array(
				array('value' => 'grid', 'label' => 'Grid'),
				array('value' => 'list', 'label' => 'List')
			);
		}
	}
?>