<?php

// Shop Archive settings
function oworganic_woo_dokan_redux_config($sections, $sidebars, $columns) {

    // Product Page
    $sections[] = array(
        'title' => esc_html__('Dokan Settings', 'oworganic'),
        'fields' => array(
            array(
                'id' => 'dokan_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('General Setting', 'oworganic').'</h3>',
            ),
            
            array(
                'id' => 'dokan_show_vendor_name',
                'type' => 'switch',
                'title' => esc_html__('Show Vendor Name', 'oworganic'),
                'default' => 1
            ),
            
            array(
                'id' => 'dokan_show_more_products',
                'type' => 'switch',
                'title' => esc_html__('Show More Products From This Vendor', 'oworganic'),
                'default' => 1
            ),

            array(
                'id' => 'dokan_show_vendor_info',
                'type' => 'switch',
                'title' => esc_html__('Show Vendor Info', 'oworganic'),
                'default' => 1
            ),
        )
    );
    
    return $sections;
}
add_filter( 'oworganic_redux_framwork_configs', 'oworganic_woo_dokan_redux_config', 10, 3 );