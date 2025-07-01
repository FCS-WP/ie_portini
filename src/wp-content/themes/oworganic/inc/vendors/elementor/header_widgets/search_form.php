<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Header Search Form', 'oworganic' );
    }
    
	public function get_categories() {
        return [ 'oworganic-header-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'oworganic' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label' => esc_html__( 'Show Categories', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Show', 'oworganic' ),
                'label_off' => esc_html__( 'Hide', 'oworganic' ),
            ]
        );

        $this->add_control(
            'show_auto_search',
            [
                'label' => esc_html__( 'Show Autocomplete Search', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Show', 'oworganic' ),
                'label_off' => esc_html__( 'Hide', 'oworganic' ),
            ]
        );

        $this->add_responsive_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style1' => esc_html__( 'Style 1', 'oworganic' ),
                    'style2' => esc_html__( 'Style 2', 'oworganic' ),
                    'style3' => esc_html__( 'Style 3', 'oworganic' ),
                ],
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'quick_links_title',
            [
                'label' => esc_html__( 'Quick Links Title', 'oworganic' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'oworganic' ),
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );

        $custom_menus = array();
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                if ( is_object( $menu ) && isset( $menu->name, $menu->slug ) ) {
                    $custom_menus[ $menu->slug ] = $menu->name;
                }
            }
        }

        $this->add_control(
            'nav_menu',
            [
                'label' => esc_html__( 'Quick Links Menu', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $custom_menus,
                'default' => '',
                'condition' => [
                    'style' => 'style2',
                ],
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'oworganic' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'oworganic' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__( 'Box', 'oworganic' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'oworganic' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon', 'oworganic' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .show-search-header' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__( 'Color Hover', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .show-search-header:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .show-search-header:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'oworganic' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Color', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-search' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hv_color',
            [
                'label' => esc_html__( 'Color Hover', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-search:hover, {{WRAPPER}} .btn-search:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        ?>
        
        <div class="apus-search-form <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ( $style == 'style2' ) { ?>
                <span class="show-search-header">
                    <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-search">
                        <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z" class="">
                        </path>
                    </svg>
                </span>
            <?php } ?>
            <div class="apus-search-form-inner <?php echo esc_attr($style); ?>">
                <?php if ( $style == 'style2' ) { ?>
                    <div class="container">
                        <div class="flex-middle top-search">
                            <h3 class="title"><?php esc_html_e('WHAT ARE YOU LOOKING FOR?', 'oworganic'); ?></h3>
                            <div class="ali-right">
                                <span class="close-search"><i class="ti-close"></i></span>
                            </div>
                        </div>
                <?php } ?>
                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                    <div class="main-search">
                        <?php if ( $show_auto_search ) echo '<div class="twitter-typeahead">'; ?>
                            <input type="text" placeholder="<?php esc_attr_e( 'Search products...', 'oworganic' ); ?>" name="s" class="apus-search form-control <?php echo esc_attr($show_auto_search ? 'apus-autocompleate-input' : ''); ?>" autocomplete="off"/>
                        <?php if ( $show_auto_search ) echo '</div>'; ?>
                    </div>
                    <input type="hidden" name="post_type" value="product" class="post_type" />
                    <?php 
                        if ( $show_categories && oworganic_is_woocommerce_activated() ) {
                            $args = array(
                                'show_count' => 0,
                                'hierarchical' => true,
                                'show_uncategorized' => 0
                            );
                            echo '<div class="select-category">';
                                wc_product_dropdown_categories( $args );
                            echo '</div>';
                        }
                    ?>
                    <button type="submit" class="btn-search">
                        <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-search">
                            <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z" class="">
                            </path>
                        </svg>
                    </button>
                </form>
                <?php if ( $style == 'style2' ) {

                        $menu_id = 0;
                        if ($nav_menu) {
                            $term = get_term_by( 'slug', $nav_menu, 'nav_menu' );
                            if ( !empty($term) ) {
                                $menu_id = $term->term_id;
                            }
                        }
                        ?>
                        <?php if ( !empty($menu_id) ) { ?>
                            <div class="quick-links-wrapper">
                                <?php if ( $quick_links_title ) {
                                    ?>
                                    <h4 class="title-quick-links"><?php echo esc_html($quick_links_title); ?></h4>
                                    <?php
                                }
                                    $nav_menu_args = array(
                                        'fallback_cb' => '',
                                        'menu'        => $menu_id
                                    );

                                    wp_nav_menu( $nav_menu_args, $menu_id );
                                ?>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
            </div>
            <?php if ( $style == 'style2' ) { ?>
                <div class="overlay-search-header"></div>
            <?php } ?>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Search_Form );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Search_Form );
}