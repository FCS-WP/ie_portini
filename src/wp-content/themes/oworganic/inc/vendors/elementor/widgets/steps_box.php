<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Steps_Box extends Widget_Base {

	public function get_name() {
        return 'apus_element_steps_box';
    }

	public function get_title() {
        return esc_html__( 'Apus Steps Box', 'oworganic' );
    }

	public function get_icon() {
        return 'eicon-image-box';
    }

	public function get_categories() {
        return [ 'oworganic-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Steps Box', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();


        $repeater->add_control(
            'step_text',
            [
                'label' => esc_html__( 'Step', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'number', 'oworganic' ),
                'placeholder' => esc_html__( 'Enter your Step', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'title_text',
            [
                'label' => esc_html__( 'Title & Description', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'This is the heading', 'oworganic' ),
                'placeholder' => esc_html__( 'Enter your title', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'description_text',
            [
                'label' => esc_html__( 'Content', 'oworganic' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'oworganic' ),
                'placeholder' => esc_html__( 'Enter your description', 'oworganic' ),
                'separator' => 'none',
                'rows' => 10,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link to', 'oworganic' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'oworganic' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'features',
            [
                'label' => esc_html__( 'Steps Box', 'oworganic' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
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
                'label' => esc_html__( 'Style', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'step_color',
            [
                'label' => esc_html__( 'Step Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .step' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Step Typography', 'oworganic' ),
                'name' => 'step',
                'selector' => '{{WRAPPER}} .step',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'oworganic' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Description Typography', 'oworganic' ),
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($features) ) {

            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $columns_tablet;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;

            ?>
            <div class="widget-steps-box <?php echo esc_attr($el_class); ?>">
                <?php
                    $mdcol = 12/$columns;
                    $smcol = 12/$columns_tablet;
                    $xscol = 12/$columns_mobile;
                ?>  
                <div class="row">
                    <?php foreach ($features as $item): ?>
                            <div class="item col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr($xscol); ?>">

                                <?php
                                $has_content = ! empty( $item['title_text'] ) || ! empty( $item['description_text'] ) || ! empty( $item['step_text'] ) ;
                                $html = '';

                                if ( $has_content ) {
                                    $html .= '<div class="steps-box-content cleafix">';

                                    if ( ! empty( $item['step_text'] ) ) {
                                        $html .= sprintf( '<div class="step">%1$s</div>', $item['step_text'] );
                                    }

                                    $html .= '<div class="inner">';

                                        if ( ! empty( $item['title_text'] ) ) {
                                            
                                            $title_html = $item['title_text'];

                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $html .= '<a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'><h3 class="title">'.$title_html.'</h3></a>';
                                            } else {
                                                $html .= sprintf( '<h3 class="title">%1$s</h3>', $title_html );
                                            }
                                        }

                                        if ( ! empty( $item['description_text'] ) ) {
                                            $html .= sprintf( '<div class="description">%1$s</div>', $item['description_text'] );
                                        }

                                    $html .= '</div>';

                                    $html .= '</div>';
                                }

                                echo trim($html);
                                ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Steps_Box );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Steps_Box );
}