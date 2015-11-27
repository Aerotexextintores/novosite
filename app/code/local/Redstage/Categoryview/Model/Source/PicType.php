<?php
	class Redstage_Categoryview_Model_Source_PicType{
		public function toOptionArray(){
			return array(
				array('value' => 'image', 'label' => 'Image'),
				array('value' => 'thumbnail', 'label' => 'Thumbnail')
			);
		}
	}
?>