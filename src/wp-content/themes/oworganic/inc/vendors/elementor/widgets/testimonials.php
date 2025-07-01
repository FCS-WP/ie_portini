<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Testimonials extends Widget_Base {

	public function get_name() {
        return 'apus_element_testimonials';
    }

	public function get_title() {
        return esc_html__( 'Apus Testimonials', 'oworganic' );
    }

	public function get_icon() {
        return 'eicon-testimonial';
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

        $repeater = new Repeater();

        $repeater->add_control(
            'title', [
                'label' => esc_html__( 'Header Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'oworganic' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label' => esc_html__( 'Rating', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    1 => esc_html__('1 Star', 'oworganic'),
                    2 => esc_html__('2 Star', 'oworganic'),
                    3 => esc_html__('3 Star', 'oworganic'),
                    4 => esc_html__('4 Star', 'oworganic'),
                    5 => esc_html__('5 Star', 'oworganic'),
                ),
                'default' => 5,
            ]
        );

        $repeater->add_control(
            'description', [
                'label' => esc_html__( 'Description', 'oworganic' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Description' , 'oworganic' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'info',
            [
                'label' => esc_html__( 'Info', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label' => esc_html__( 'Job', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'oworganic' ),
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

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'oworganic' ),
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'oworganic' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'oworganic' ),
                'label_off' => esc_html__( 'Show', 'oworganic' ),
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'oworganic' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'oworganic' ),
                'label_off' => esc_html__( 'Show', 'oworganic' ),
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
            ]
        );
        
        $this->add_responsive_control(
            'banner_align',
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
                    '{{WRAPPER}} .testimonials-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'oworganic'),
                    'style2' => esc_html__('Style 2', 'oworganic'),
                    'style3' => esc_html__('Style 3', 'oworganic'),
                ),
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'style_nav',
            [
                'label' => esc_html__( 'Style Nav', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'oworganic'),
                    'st_white' => esc_html__('White', 'oworganic'),
                ),
                'default' => ''
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
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
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
            'test_description_color',
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
                'name' => 'test_description_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'test_info_color',
            [
                'label' => esc_html__( 'Info Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .info' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Info Typography', 'oworganic' ),
                'name' => 'test_info_typography',
                'selector' => '{{WRAPPER}} .info',
            ]
        );

        $this->add_control(
            'job',
            [
                'label' => esc_html__( 'Job Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Job Typography', 'oworganic' ),
                'name' => 'test_job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__( 'Dots Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .slick-dots li button ' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_hover_color',
            [
                'label' => esc_html__( 'Dots Hover Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($testimonials) ) {
            ?>
            <div class="widget-testimonials <?php echo esc_attr($el_class.' '.$style.' '.$style_nav); ?>">
                <div class="slick-carousel"
                        data-items="<?php echo esc_attr($columns); ?>"
                        data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                        data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                        data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                        data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                        data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                        data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                    <?php foreach ($testimonials as $item) { ?>
                        <div class="item">
                            <?php if($style == 'style3') { ?>
                                <div class="testimonials-item">
                                    <div class="testimonial-content">
                                        <?php if ( !empty($item['title']) ) { ?>
                                            <h3 class="title"><?php echo trim($item['title']); ?></h3>
                                        <?php } ?>
                                        <?php if ( !empty($item['description']) ) { ?>
                                            <div class="description"><?php echo trim($item['description']); ?></div>
                                        <?php } ?>

                                        <div class="rating-customers">
                                            <div class="inner" style="width: <?php echo esc_attr($item['rating']*20).'%'; ?>">
                                            </div>
                                        </div>

                                        <?php
                                        $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : '';
                                        if ( $img_src ) {
                                            ?>
                                            <div class="avarta">
                                                <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>

                                        <div class="info-testimonial">
                                            <?php if ( !empty($item['info']) ) { ?>
                                                <div class="info"><?php echo trim($item['info']); ?></div>
                                            <?php } ?>
                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job">/ <?php echo trim($item['job']); ?></div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>
                            <?php } elseif ( $style == 'style2' ) { ?>
                                <div class="testimonials-item">
                                    <div class="testimonial-content">
                                        <?php if ( !empty($item['title']) ) { ?>
                                            <h3 class="title"><?php echo trim($item['title']); ?></h3>
                                        <?php } ?>
                                        <?php if ( !empty($item['description']) ) { ?>
                                            <div class="description"><?php echo trim($item['description']); ?></div>
                                        <?php } ?>

                                        <div class="rating-customers">
                                            <div class="inner" style="width: <?php echo esc_attr($item['rating']*20).'%'; ?>">
                                            </div>
                                        </div>

                                        <?php
                                        $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : '';
                                        if ( $img_src ) {
                                            ?>
                                            <div class="avarta">
                                                <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>

                                        <div class="info-testimonial">
                                            <?php if ( !empty($item['info']) ) { ?>
                                                <div class="info"><?php echo trim($item['info']); ?></div>
                                            <?php } ?>
                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job">/ <?php echo trim($item['job']); ?></div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    
                                </div>
                            <?php }else{ ?>
                                <div class="testimonials-item">
                                    <div class="testimonial-content">
                                        <?php if ( !empty($item['title']) ) { ?>
                                            <h3 class="title"><?php echo trim($item['title']); ?></h3>
                                        <?php } ?>

                                        <div class="rating-customers">
                                            <div class="inner" style="width: <?php echo esc_attr($item['rating']*20).'%'; ?>">
                                            </div>
                                        </div>

                                        <?php if ( !empty($item['description']) ) { ?>
                                            <div class="description"><?php echo trim($item['description']); ?></div>
                                        <?php } ?>

                                        <div class="info-testimonial">
                                            <?php if ( !empty($item['info']) ) { ?>
                                                <div class="info"><?php echo trim($item['info']); ?></div>
                                            <?php } ?>
                                            <?php if ( !empty($item['job']) ) { ?>
                                                <div class="job">/ <?php echo trim($item['job']); ?></div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    


                                    <?php
                                    $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : '';
                                    if ( $img_src ) {
                                    ?>
                                    <div class="avarta">
                                        <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                    </div>
                                    <?php } ?>


                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Testimonials );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Testimonials );
}