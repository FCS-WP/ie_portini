<?php

// Shop Archive settings
function oworganic_woo_redux_config($sections, $sidebars, $columns) {
    $attributes = array();
    if ( is_admin() ) {
        $attrs = wc_get_attribute_taxonomies();
        if ( $attrs ) {
            foreach ( $attrs as $tax ) {
                $attributes[wc_attribute_taxonomy_name( $tax->attribute_name )] = $tax->attribute_label;
            }
        }
    }
    $sections[] = array(
        'icon' => 'el el-shopping-cart',
        'title' => esc_html__('Shop Settings', 'oworganic'),
        'fields' => array(
            array(
                'id' => 'products_general_total_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('General Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'enable_shop_catalog',
                'type' => 'switch',
                'title' => esc_html__('Enable Shop Catalog', 'oworganic'),
                'default' => 0,
                'subtitle' => esc_html__('Enable Catalog Mode for disable Add To Cart button, Cart, Checkout', 'oworganic'),
            ),
            array(
                'id' => 'products_breadcrumb_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Breadcrumbs Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'show_product_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'oworganic'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'oworganic'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'oworganic').'</em>',
                'id' => 'woo_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'oworganic'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'oworganic'),
            ),
        )
    );

    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Product Archives', 'oworganic'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'products_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Sidebar Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'product_archive_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'oworganic'),
                'default' => false
            ),
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'oworganic'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'oworganic'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'oworganic'),
                        'alt' => esc_html__('Main Content', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left Sidebar - Main Content', 'oworganic'),
                        'alt' => esc_html__('Left Sidebar - Main Content', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main Content - Right Sidebar', 'oworganic'),
                        'alt' => esc_html__('Main Content - Right Sidebar', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_archive_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Left Sidebar', 'oworganic'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'oworganic'),
                'options' => $sidebars,
                'required' => array('product_archive_layout', '=', array('left-main'))
            ),
            array(
                'id' => 'product_archive_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Right Sidebar', 'oworganic'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'oworganic'),
                'options' => $sidebars,
                'required' => array('product_archive_layout', '=', array('main-right'))
            ),
            array(
                'id' => 'product_archive_show_filter_top',
                'type' => 'switch',
                'title' => esc_html__('Show Filter Top', 'oworganic'),
                'default' => 1,
                'required' => array('product_archive_layout', '=', array('main'))
            ),
            array(
                'id' => 'products_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('General Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'select',
                'title' => esc_html__('Products Layout', 'oworganic'),
                'subtitle' => esc_html__('Choose a default layout archive product.', 'oworganic'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'oworganic'),
                    'list' => esc_html__('List', 'oworganic'),
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'oworganic'),
                'options' => $columns,
                'default' => 4,
                'required' => array('product_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'product_item_style',
                'type' => 'select',
                'title' => esc_html__('Product Style', 'oworganic'),
                'options' => array(
                    'v1' => esc_html__('Style 1', 'oworganic'),
                    'v2' => esc_html__('Style 2', 'oworganic'),
                    'v3' => esc_html__('Style 3', 'oworganic'),
                    'v4' => esc_html__('Style 4', 'oworganic'),
                ),
                'default' => 'v1',
                'required' => array('product_display_mode', '=', array('grid'))
            ),

            array(
                'id' => 'number_products_per_page',
                'type' => 'text',
                'title' => esc_html__('Number of Products Per Page', 'oworganic'),
                'default' => 12,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'show_quickview',
                'type' => 'switch',
                'title' => esc_html__('Show Quick View', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'enable_swap_image',
                'type' => 'switch',
                'title' => esc_html__('Enable Swap Image', 'oworganic'),
                'default' => 1
            ),

        )
    );
    
    
    // Product Page
    $sections[] = array(
        'title' => esc_html__('Single Product', 'oworganic'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'product_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('General Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'product_thumbs_position',
                'type' => 'select',
                'title' => esc_html__('Thumbnails Position', 'oworganic'),
                'options' => array(
                    'thumbnails-left' => esc_html__('Thumbnails Left', 'oworganic'),
                    'thumbnails-right' => esc_html__('Thumbnails Right', 'oworganic'),
                    'thumbnails-bottom' => esc_html__('Thumbnails Bottom', 'oworganic'),
                ),
                'default' => 'thumbnails-bottom',
            ),
            array(
                'id' => 'number_product_thumbs',
                'title' => esc_html__('Number Thumbnails Per Row', 'oworganic'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '8',
                'type' => 'slider',
            ),
            array(
                'id' => 'show_product_countdown_timer',
                'type' => 'switch',
                'title' => esc_html__('Show Product CountDown Timer', 'oworganic'),
                'subtitle' => esc_html__('For only product deal', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_meta',
                'type' => 'switch',
                'title' => esc_html__('Show Product Meta', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Show Product Review Tab', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'hidden_product_additional_information_tab',
                'type' => 'switch',
                'title' => esc_html__('Hidden Product Additional Information Tab', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'product_content_layout',
                'type' => 'select',
                'title' => esc_html__('Product Content Layout', 'oworganic'),
                'options' => array(
                    'tabs' => esc_html__('Tabs', 'oworganic'),
                    'accordion' => esc_html__('Accordion', 'oworganic'),
                ),
                'default' => 'tabs',
            ),
            
            array(
                'id' => 'product_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Single Product Sidebar Layout', 'oworganic'),
                'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'oworganic'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'oworganic'),
                        'alt' => esc_html__('Main Only', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'oworganic'),
                        'alt' => esc_html__('Left - Main Sidebar', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'oworganic'),
                        'alt' => esc_html__('Main - Right Sidebar', 'oworganic'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'oworganic'),
                'default' => false
            ),
            array(
                'id' => 'product_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Left Sidebar', 'oworganic'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'oworganic'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Right Sidebar', 'oworganic'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'oworganic'),
                'options' => $sidebars
            ),

            array(
                'id' => 'product_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Product Block Setting', 'oworganic').'</h3>',
            ),
            array(
                'id' => 'show_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Show Products Releated', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'oworganic'),
                'options' => $columns,
                'default' => 4,
                'required' => array('show_product_releated', '=', true)
            ),

            array(
                'id' => 'show_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Show Products upsells', 'oworganic'),
                'default' => 1
            ),
            array(
                'id' => 'upsells_product_columns',
                'type' => 'select',
                'title' => esc_html__('Upsells Products Columns', 'oworganic'),
                'options' => $columns,
                'default' => 4,
                'required' => array('show_product_upsells', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'oworganic_redux_framwork_configs', 'oworganic_woo_redux_config', 10, 3 );