<?php

class Redstage_Categoryview_Model_Setup extends Mage_Eav_Model_Entity_Setup
{

	/**
	 * @return array
	 */
	public function getDefaultEntities()
	{

		return array(
			'catalog_category' => array(
				'entity_model'      => 'catalog/category',
				'attribute_model'   => 'catalog/resource_eav_attribute',
				'table'             => 'catalog/category',
				'additional_attribute_table' => 'catalog/eav_attribute',
				'entity_attribute_collection' => 'catalog/category_attribute_collection',
				'attributes'        => array(
					'subcategoryview' => array(
						'group'             => 'Display Settings',
						'label'             => 'Show Subcategory List',
						'type'              => 'int',
						'input'             => 'select',
						'default'           => '0',
						'class'             => '',
						'backend'           => '',
						'frontend'          => '',
						'source'            => 'eav/entity_attribute_source_boolean',
						'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
						'visible'           => true,
						'required'          => false,
						'user_defined'      => '1',
						'searchable'        => false,
						'filterable'        => false,
						'comparable'        => false,
						'visible_on_front'  => false,
						'visible_in_advanced_search' => false,
						'unique'            => false
					)

				)
			)

		);

	}

}

?>