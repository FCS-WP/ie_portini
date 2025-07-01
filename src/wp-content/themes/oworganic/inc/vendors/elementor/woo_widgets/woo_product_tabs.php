<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Woo_Product_Tabs extends Widget_Base {

	public function get_name() {
        return 'apus_element_woo_product_tabs';
    }

	public function get_title() {
        return esc_html__( 'Apus Product Tabs', 'oworganic' );
    }

    public function get_icon() {
        return 'fa fa-shopping-bag';
    }

	public function get_categories() {
        return [ 'oworganic-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Tab Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'type',
            [
                'label' => esc_html__( 'Get Products By', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'recent_product' => esc_html__('Recent Products', 'oworganic' ),
                    'best_selling' => esc_html__('Best Selling', 'oworganic' ),
                    'featured_product' => esc_html__('Featured Products', 'oworganic' ),
                    'top_rate' => esc_html__('Top Rate', 'oworganic' ),
                    'on_sale' => esc_html__('On Sale', 'oworganic' ),
                    'recent_review' => esc_html__('Recent Review', 'oworganic' ),
                    'recently_viewed' => esc_html__('Recent Viewed', 'oworganic' ),
                ),
                'default' => 'recent_product'
            ]
        );

        $repeater->add_control(
            'slugs',
            [
                'label' => esc_html__( 'Category Slug', 'oworganic' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter slug spearate by comma(,)', 'oworganic' ),
            ]
        );

        // banner
        $repeater->add_control(
            'show_banner',
            [
                'label'         => esc_html__( 'Show Banner', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'oworganic' ),
                'label_off'     => esc_html__( 'No', 'oworganic' ),
                'return_value'  => true,
                'default'       => false,
                'separator' => 'before',
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $repeater->add_responsive_control(
            'banner_columns',
            [
                'label' => esc_html__( 'Columns', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Banner Image', 'oworganic' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Background Image', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'banner_title',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'oworganic' ),
                'default' => '',
            ]
        );

        $repeater->add_control(
            'show_products_count',
            [
                'label'         => esc_html__( 'Show Products Count', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'oworganic' ),
                'label_off'     => esc_html__( 'No', 'oworganic' ),
                'return_value'  => true,
                'default'       => false,
            ]
        );

        $repeater->add_control(
            'banner_link',
            [
                'label' => esc_html__( 'URL', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Button Link here', 'oworganic' ),
                'default' => '',
            ]
        );
        
        ///

        $this->add_control(
            'title', [
                'label' => esc_html__( 'Widget Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs', 'oworganic' ),
                'type' => Controls_Manager::REPEATER,
                'placeholder' => esc_html__( 'Enter your product tabs here', 'oworganic' ),
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'oworganic' ),
                'type' => Controls_Manager::NUMBER,
                'placeholder' => esc_html__( 'Enter number products to display', 'oworganic' ),
                'default' => 4
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'oworganic'),
                    'carousel' => esc_html__('Carousel', 'oworganic'),
                ),
                'default' => 'grid'
            ]
        );
        $this->add_control(
            'product_item',
            [
                'label' => esc_html__( 'Product Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'inner' => esc_html__('Style 1', 'oworganic'),
                    'inner-v2' => esc_html__('Style 2', 'oworganic'),
                    'inner-v3' => esc_html__('Style 3', 'oworganic'),
                    'inner-v4' => esc_html__('Style 4', 'oworganic'),
                    'inner-v5' => esc_html__('Style 5', 'oworganic'),
                    'inner-v6' => esc_html__('Style 6', 'oworganic'),
                ),
                'default' => 'inner',
            ]
        );


        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'oworganic' ),
                'options' => $columns,
                'condition' => [
                    'columns!' => '1',
                    'layout_type' => 'carousel',
                ],
                'frontend_available' => true,
                'default' => 1,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'oworganic' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'oworganic' ),
                'label_off'     => esc_html__( 'Hide', 'oworganic' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'oworganic' ),
                'label_off'     => esc_html__( 'Hide', 'oworganic' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'oworganic' ),
                'label_off'     => esc_html__( 'No', 'oworganic' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'oworganic' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'oworganic' ),
                'label_off'     => esc_html__( 'No', 'oworganic' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'carousel_type',
            [
                'label' => esc_html__( 'Carousel Type', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'oworganic'),
                    'carousel_white' => esc_html__('White', 'oworganic'),
                    'carousel_circle' => esc_html__('Circle', 'oworganic'),
                    'carousel_circle st_center' => esc_html__('Circle Center', 'oworganic'),
                ),
                'default' => '',
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'tab_type',
            [
                'label' => esc_html__( 'Position Tab', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'left' => esc_html__('Left', 'oworganic'),
                    'right' => esc_html__('Right', 'oworganic'),
                    'center' => esc_html__('Center', 'oworganic'),
                ),
                'default' => 'center'
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'oworganic' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'oworganic' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Widget Style', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'widget_title_color',
            [
                'label' => esc_html__( 'Widget Title Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Widget Title Typography', 'oworganic' ),
                'name' => 'widget_title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();

        

        $this->start_controls_section(
            'section_tab_style',
            [
                'label' => esc_html__( 'Tabs Style', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__( 'Tab Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .nav-tabs > li > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_hover_color',
            [
                'label' => esc_html__( 'Tab Hover/Active Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .nav-tabs > li.active > a, {{WRAPPER}} .nav-tabs > li.active > a:hover, {{WRAPPER}} .nav-tabs > li.active > a:focus, {{WRAPPER}} .nav-tabs > li > a:hover, {{WRAPPER}} .nav-tabs > li > a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_active_color',
            [
                'label' => esc_html__( 'Border Active Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .nav.tabs-product > li > a::before, {{WRAPPER}} .widget-title:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Tab Typography', 'oworganic' ),
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .nav-tabs > li > a',
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label' => esc_html__( 'Dot Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .slick-dots li button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_active_color',
            [
                'label' => esc_html__( 'Dot Active Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__( 'Box Style', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'oworganic' ),
                'selector' => '{{WRAPPER}} .product-block',
            ]
        );

        $this->add_control(
            'box_hover_border_color',
            [
                'label' => esc_html__( 'Border Hover Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-block:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow Hover', 'oworganic' ),
                'selector' => '{{WRAPPER}} .product-block:hover',
            ]
        );

        $this->add_control(
            'bg-image',
            [
                'label' => esc_html__( 'Background Color Top Image', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'product_item' => 'inner-v7',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        
        $this->start_controls_section(
            'section_product_style',
            [
                'label' => esc_html__( 'Product Style', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} h3.name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block h3.name a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-block h3.name a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'oworganic' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} h3.name a',
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label' => esc_html__( 'Category Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Category Typography', 'oworganic' ),
                'name' => 'cat_typography',
                'selector' => '{{WRAPPER}} .product-cat',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__( 'Price Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .price' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .price ins' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'price_old_color',
            [
                'label' => esc_html__( 'Price Old Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .price del' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Price Typography', 'oworganic' ),
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .product-block .price',
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label' => esc_html__( 'Info Action Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .quickview' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .quickview:before' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .added_to_cart' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .added_to_cart:before' => 'background-color: {{VALUE}} ;',
                    '{{WRAPPER}} .product-block .button:before' => 'background-color: {{VALUE}} ;',
                    '{{WRAPPER}} .product-block .added_to_cart:after' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button:after' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'product_item!' => 'inner-v9',
                ],
            ]
        );


        $this->add_control(
            'info_v9_color',
            [
                'label' => esc_html__( 'Info Action Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .quickview' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-block .button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .product-block .yith-wcwl-add-to-wishlist a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'product_item' => 'inner-v9',
                ],
            ]
        );

        $this->add_control(
            'info_bg_color',
            [
                'label' => esc_html__( 'Info Action Background Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .quickview' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-add-to-wishlist a' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'product_item' => 'inner-v9',
                ],
            ]
        );

        $this->add_control(
            'info_bg_hv_color',
            [
                'label' => esc_html__( 'Info Action Background Color Hover', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .quickview:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .quickview:focus' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .quickview.loading::after' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button:focus' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .added_to_cart' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-wishlistaddedbrowse a' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-wishlistexistsbrowse a' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-add-to-wishlist a:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-add-to-wishlist a:focus' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'product_item' => 'inner-v9',
                ],
            ]
        );



        $this->add_control(
            'Wishlist_color',
            [
                'label' => esc_html__( 'Wishlist Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .add_to_wishlist' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'product_item!' => 'inner-v9',
                ],
            ]
        );

        $this->add_control(
            'Wishlisted_color',
            [
                'label' => esc_html__( 'Wishlist Added Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-block .yith-wcwl-wishlistexistsbrowse a' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .yith-wcwl-wishlistaddedbrowse a' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'product_item!' => 'inner-v9',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($tabs) ) {
            $_id = oworganic_random_key();
            ?>
            <div class="woocommerce widget-products-tabs <?php echo esc_attr($product_item.' '.$el_class); ?>">
                
                <div class="widget-content <?php echo esc_attr($layout_type); ?>">
                    <div class="top-info flex-middle-sm <?php echo esc_attr($tab_type); ?>">
                        <?php if ( !empty($title) && ($tab_type != 'left') ): ?>
                            <h3 class="widget-title">
                                <?php echo esc_attr( $title ); ?>
                            </h3>
                        <?php endif; ?>

                        <ul role="tablist" class="nav nav-tabs tabs-product" data-load="ajax">
                            <?php $i = 0; foreach ($tabs as $tab) : ?>
                                <li class="<?php echo esc_attr($i == 0 ? 'active' : '');?>">
                                    <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>">
                                        <?php if ( !empty($tab['title']) ) { ?>
                                            <?php echo trim($tab['title']); ?>
                                        <?php } ?>
                                    </a>
                                </li>
                            <?php $i++; endforeach; ?>
                        </ul>

                        <?php if ( !empty($title) && ($tab_type == 'left') ): ?>
                            <h3 class="widget-title">
                                <?php echo esc_attr( $title ); ?>
                            </h3>
                        <?php endif; ?>

                    </div>
                    <div class="widget-inner">
                        <div class="tab-content">
                            <?php $i = 0; foreach ($tabs as $tab) : 
                                $encoded_atts = json_encode( $settings );
                                $encoded_tab = json_encode( $tab );
                            ?>
                                <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>" class="tab-pane <?php echo esc_attr($i == 0 ? 'active' : ''); ?>" data-loaded="<?php echo esc_attr($i == 0 ? 'true' : 'false'); ?>" data-settings="<?php echo esc_attr($encoded_atts); ?>" data-tab="<?php echo esc_attr($encoded_tab); ?>">
                                    <div class="tab-content-products-wrapper row">
                                        <?php
                                        $banner_columns = $banner_columns_tablet = $banner_columns_mobile = 0;
                                        if ( !empty($tab['show_banner']) && $tab['show_banner'] ) {
                                            $banner_columns = !empty($tab['banner_columns']) ? $tab['banner_columns'] : 3;
                                            $banner_columns_tablet = !empty($tab['banner_columns_tablet']) ? $tab['banner_columns_tablet'] : 3;
                                            $banner_columns_mobile = !empty($tab['banner_columns_mobile']) ? $tab['banner_columns_mobile'] : 2;

                                            $classes = 'col-md-'.$banner_columns.' col-sm-'.$banner_columns_tablet.' col-xs-'.$banner_columns_mobile;
                                        ?>
                                            <div class="banner-wrapper <?php echo esc_attr($classes); ?>">
                                                <?php if ( !empty($tab['banner_link']) ) { ?>
                                                    <a href="<?php echo esc_url($tab['banner_link']); ?>">
                                                <?php } ?>
                                                        <div class="inner">
                                                            <?php if ( !empty($tab['img_src']['id']) ) { ?>
                                                                <div class="img-banner">
                                                                    <?php echo oworganic_get_attachment_thumbnail($tab['img_src']['id'], 'full'); ?>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if ( !empty($tab['banner_title']) ) { ?>
                                                                <h2 class="title1"><?php echo trim($tab['banner_title']); ?></h2>
                                                            <?php } ?>

                                                            <?php if ( !empty($tab['show_products_count']) && $tab['show_products_count'] ) {
                                                                $slugs = !empty($tab['slugs']) ? array_map('trim', explode(',', $tab['slugs'])) : array();
                                                                $type = isset($tab['type']) ? $tab['type'] : 'recent_product';
                                                                $args = array(
                                                                    'categories' => $slugs,
                                                                    'product_type' => $type,
                                                                    'post_per_page' => $limit,
                                                                    'fields' => 'ids'
                                                                );
                                                                $products = oworganic_get_products( $args );
                                                            ?>
                                                                <span class="product-count"><?php echo sprintf(esc_html__('%d products', 'oworganic'), $products->post_count); ?></span>
                                                            <?php } ?>
                                                        </div>
                                                <?php if ( !empty($tab['banner_link']) ) { ?>
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $classes = 'col-md-'.(12 - $banner_columns).' col-sm-'.(12 - $banner_columns_tablet).' col-xs-'.(12 - $banner_columns_mobile);
                                        ?>
                                        <div class="<?php echo esc_attr($classes); ?>">
                                            <div class="tab-content-products">
                                                <?php if ( $i == 0 ): ?>
                                                    <?php
                                                        $slugs = !empty($tab['slugs']) ? array_map('trim', explode(',', $tab['slugs'])) : array();
                                                        $type = isset($tab['type']) ? $tab['type'] : 'recent_product';
                                                        $args = array(
                                                            'categories' => $slugs,
                                                            'product_type' => $type,
                                                            'post_per_page' => $limit,
                                                        );
                                                        $loop = oworganic_get_products( $args );
                                                    ?>

                                                    <?php wc_get_template( 'layout-products/'.$layout_type.'.php' , array(
                                                        'loop' => $loop,
                                                        'columns' => $columns,
                                                        'columns_tablet' => $columns_tablet,
                                                        'columns_mobile' => $columns_mobile,
                                                        'slides_to_scroll' => $slides_to_scroll,
                                                        'slides_to_scroll_tablet' => $slides_to_scroll_tablet,
                                                        'slides_to_scroll_mobile' => $slides_to_scroll_mobile,
                                                        'show_nav' => $show_nav,
                                                        'show_pagination' => $show_pagination,
                                                        'autoplay' => $autoplay,
                                                        'infinite_loop' => $infinite_loop,
                                                        'rows' => $rows,
                                                        'product_item' => $product_item,
                                                        'slick_top' => 'slick-carousel-top',
                                                        'carousel_type' => $carousel_type,
                                                        'elementor_element' => true,
                                                    ) ); ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Woo_Product_Tabs );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Woo_Product_Tabs );
}