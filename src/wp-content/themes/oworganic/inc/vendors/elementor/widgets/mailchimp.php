<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Mailchimp extends Widget_Base {

	public function get_name() {
        return 'apus_element_mailchimp';
    }

	public function get_title() {
        return esc_html__( 'Apus MailChimp Sign-Up Form', 'oworganic' );
    }
    
	public function get_categories() {
        return [ 'oworganic-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'MailChimp Sign-Up Form', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'st1' => esc_html__('Style 1', 'oworganic'),
                    'st2' => esc_html__('Style 2', 'oworganic'),
                    'st3' => esc_html__('Style 3', 'oworganic'),
                ),
                'default' => 'st1'
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
            'section_button_style',
            [
                'label' => esc_html__( 'Style Button', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'style_tabs'
        );
            $this->start_controls_tab(
                'style_normal_tab',
                [
                    'label' => esc_html__( 'Normal', 'oworganic' ),
                ]
            );
                $this->add_control(
                    'button_color',
                    [
                        'label' => esc_html__( 'Text Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn ' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button_bg_color',
                    [
                        'label' => esc_html__( 'BG Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn ' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button_br_color',
                    [
                        'label' => esc_html__( 'Border Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn ' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'style_hover_tab',
                [
                    'label' => esc_html__( 'Hover', 'oworganic' ),
                ]
            );

                $this->add_control(
                    'button_hv_color',
                    [
                        'label' => esc_html__( 'Text Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn:focus ' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .btn:hover ' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button_hv_bg_color',
                    [
                        'label' => esc_html__( 'BG Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn:hover ' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .btn:focus ' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .btn:before ' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button_hv_br_color',
                    [
                        'label' => esc_html__( 'Border Color', 'oworganic' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .btn:hover ' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .btn:focus ' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'oworganic' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Button Typography', 'oworganic' ),
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .btn',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label' => esc_html__( 'Style Input', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__( 'Text Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} [type="email"] ' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'input_pl_color',
            [
                'label' => esc_html__( 'Placeholder Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} [type="email"]::-moz-placeholder ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} [type="email"]:-ms-input-placeholder ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} [type="email"]:-moz-placeholder ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__( 'BG Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} [type="email"] ' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_br_color',
            [
                'label' => esc_html__( 'Border Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} [type="email"] ' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .widget-mailchimp form ' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_input_radius',
            [
                'label' => esc_html__( 'Border Radius', 'oworganic' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} [type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Input Typography', 'oworganic' ),
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} [type="email"]',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-mailchimp <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php
            if ( function_exists('mc4wp_show_form') ) {
                mc4wp_show_form('');
            }
            ?>
        </div>
        <?php
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Mailchimp );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Mailchimp );
}