<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Nav_Menu extends Widget_Base {

	public function get_name() {
        return 'apus_element_nav_menu';
    }

	public function get_title() {
        return esc_html__( 'Apus Navigation Menu', 'oworganic' );
    }
    
	public function get_categories() {
        return [ 'oworganic-elements' ];
    }

	protected function register_controls() {

        $custom_menus = array();
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                if ( is_object( $menu ) && isset( $menu->name, $menu->slug ) ) {
                    $custom_menus[ $menu->slug ] = $menu->name;
                }
            }
        }

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Navigation Menu', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'oworganic' ),
            ]
        );

        $this->add_control(
            'nav_menu',
            [
                'label' => esc_html__( 'Menu', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => $custom_menus,
                'default' => ''
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'oworganic'),
                    'st_line' => esc_html__('Line', 'oworganic'),
                    'st_no_line' => esc_html__('No Line', 'oworganic'),
                    'st_uppercase' => esc_html__('Uppercase', 'oworganic'),
                ),
                'default' => ''
            ]
        );

        $this->add_responsive_control(
            'menu_align',
            [
                'label' => esc_html__( 'Alignment', 'oworganic' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'oworganic' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'oworganic' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'oworganic' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'oworganic' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-nav-menu' => 'text-align: {{VALUE}};',
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



        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
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
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'oworganic' ),
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => esc_html__( 'Menu Item', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => esc_html__( 'Menu Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'menu_color_hover',
            [
                'label' => esc_html__( 'Menu Color Hover', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Menu Typography', 'oworganic' ),
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .widget-content a',
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label' => esc_html__( 'Line Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .menu li a::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $menu_id = 0;
        if ($nav_menu) {
            $term = get_term_by( 'slug', $nav_menu, 'nav_menu' );
            if ( !empty($term) ) {
                $menu_id = $term->term_id;
            }
        }

        ?>
        <div class="widget-nav-menu <?php echo esc_attr($el_class.' '.$style); ?>">
            
            <?php if ( !empty($title) ) { ?>
                <h2 class="widget-title"><?php echo trim($title); ?></h2>
            <?php } ?>

            <?php if ( !empty($menu_id) ) { ?>
                <div class="widget-content">
                    <?php
                        $nav_menu_args = array(
                            'fallback_cb' => '',
                            'menu'        => $menu_id
                        );

                        wp_nav_menu( $nav_menu_args, $menu_id );
                    ?>
                </div>
            <?php } ?>

        </div>
        <?php
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Nav_Menu );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Nav_Menu );
}