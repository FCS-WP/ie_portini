<?php

if ( !function_exists( 'oworganic_product_metaboxes' ) ) {
	function oworganic_product_metaboxes(array $metaboxes) {
		$prefix = 'apus_product_';
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'oworganic' )), oworganic_get_header_layouts() );
	    $fields = array(
	    	array(
                'id' => $prefix.'layout_type',
                'type' => 'select',
                'name' => esc_html__('Layout Type', 'oworganic'),
                'options' => array(
                    '' => esc_html__('Global Settings', 'oworganic'),
                    'v1' => esc_html__('Layout 1', 'oworganic'),
                    'v2' => esc_html__('Layout 2', 'oworganic'),
                    'v3' => esc_html__('Layout 3', 'oworganic'),
                    'v4' => esc_html__('Layout 4', 'oworganic'),
                    'v5' => esc_html__('Layout 5', 'oworganic'),
                )
            ),
	    	array(
				'name' => esc_html__( 'Review Video', 'oworganic' ),
				'id'   => $prefix.'review_video',
				'type' => 'text',
				'description' => esc_html__( 'You can enter a video youtube or vimeo', 'oworganic' ),
			),
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'More Information', 'oworganic' ),
			'object_types'              => array( 'product' ),
			'context'                   => 'normal',
			'priority'                  => 'low',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'oworganic_product_metaboxes' );
