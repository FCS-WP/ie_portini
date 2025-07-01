<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Woo_Products_Specific extends Widget_Base {

	public function get_name() {
        return 'apus_element_woo_products_specific';
    }

	public function get_title() {
        return esc_html__( 'Apus Products Specific', 'oworganic' );
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
        
        $this->add_control(
            'title', [
                'label' => esc_html__( 'Widget Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'product_ids', [
                'label' => esc_html__( 'Product IDS', 'oworganic' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter your product id here', 'oworganic' ),
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
            'carousel_style',
            [
                'label' => esc_html__( 'Carousel Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'oworganic'),
                    'carousel_vertical' => esc_html__('Vertical', 'oworganic'),
                    'carousel_vertical carousel_2' => esc_html__('Vertical 2', 'oworganic'),
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
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'oworganic' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'oworganic' ),
            ]
        );

        $this->end_controls_section();


        // Style
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Box Style', 'oworganic' ),
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
                    '{{WRAPPER}} .product-block .added_to_cart' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .added_to_cart:before' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .product-block .button:before' => 'background-color: {{VALUE}} !important;',
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
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $product_ids = !empty($product_ids) ? array_filter(explode(',', $product_ids)) : '';
        if ( $product_ids ) {
        ?>
            <div class="woocommerce widget-products-deal <?php echo esc_attr($product_item.' '.$el_class); ?>">
                <?php if ( !empty($title) ): ?>
                    <h3 class="widget-title">
                        <?php echo esc_attr( $title ); ?>
                    </h3>
                <?php endif; ?>
                <div class="widget-content <?php echo esc_attr($layout_type); ?>">
                    <?php if ( $layout_type == 'carousel' ) { ?>

                        <?php
                        $product_item = isset($product_item) ? $product_item : 'inner';

                        $show_nav = isset($show_nav) ? $show_nav : false;
                        $show_pagination = isset($show_pagination) ? $show_pagination : false;

                        $rows = isset($rows) ? $rows : 1;
                        $columns = !empty($columns) ? $columns : 3;
                        if($columns > 1){
                            $columns_tablet = 2;
                        }else{
                            $columns_tablet = 1;
                        }
                        $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;

                        $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
                        $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
                        $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;

                        $infinite_loop = isset($infinite_loop) ? $infinite_loop : false;
                        $autoplay = isset($autoplay) ? $autoplay : false;
                        ?>
                        <div class="slick-carousel products carousel_small <?php echo trim($carousel_style); ?>"
                            data-items="<?php echo esc_attr($columns); ?>"
                            data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                            data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                            data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                            data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                            data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                            data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>">

                            <?php
                            foreach ($product_ids as $product_id) {
                                if ( !empty($product_id) ) {
                                    $post_object = get_post( $product_id );
                                    if ( $post_object ) {
                                        setup_postdata( $GLOBALS['post'] =& $post_object );
                                        ?>
                                            <div class="products-grid product">
                                                <?php wc_get_template_part( 'item-product/'.$product_item ); ?>
                                            </div>
                                        <?php
                                    }
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <?php
                            $product_item = isset($product_item) ? $product_item : 'inner';
                            $columns = !empty($columns) ? $columns : 3;
                            if($columns > 1){
                                $columns_tablet = 2;
                            }else{
                                $columns_tablet = 1;
                            }
                            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;

                            $mdcol = 12/$columns;
                            $smcol = 12/$columns_tablet;
                            $xscol = 12/$columns_mobile;

                            if( $columns == 5 ){
                                $mdcol = '5c';
                            }

                            if( $columns_tablet == 5 ){
                                $smcol = '5c';
                            }

                            if( $columns_mobile == 5 ){
                                $xscol = '5c';
                            }

                            $classes = array();

                            $classes[] = 'col-md-'.$mdcol.' col-sm-'.$smcol.' col-xs-'.$xscol;

                            $count = 0;
                            foreach ($product_ids as $product_id) {
                                
                                if ( !empty($product_id) ) {
                                    $post_object = get_post( $product_id );
                                    if ( $post_object ) {
                                        setup_postdata( $GLOBALS['post'] =& $post_object );
                                        $pclasses = $classes;
                                        if ( $count%$columns == 0 ) {
                                            $pclasses[] = 'md-clearfix lg-clearfix ';
                                        }
                                        ?>
                                            <div <?php wc_product_class( $pclasses, $post_object ); ?>>
                                                <?php wc_get_template_part( 'item-product/'.$product_item ); ?>
                                            </div>
                                        <?php
                                        $count++;
                                    }
                                }
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <?php
        }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Woo_Products_Specific );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Woo_Products_Specific );
}