<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Special_Banner extends Widget_Base {

	public function get_name() {
        return 'apus_element_special_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Special Banner', 'oworganic' );
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
                'label' => esc_html__( 'Special Banner', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'oworganic' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
                'condition' => [
                    'image_icon' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'title_text',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'products_count',
            [
                'label' => esc_html__( 'Products Count', 'oworganic' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
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
            'banners',
            [
                'label' => esc_html__( 'Banners Item', 'oworganic' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'animation',
            [
                'label' => esc_html__( 'Animation', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('None', 'oworganic'),
                    'fade' => esc_html__('Fade', 'oworganic'),
                    'fade-up' => esc_html__('Fade Up', 'oworganic'),
                    'fade-down' => esc_html__('Fade Down', 'oworganic'),
                    'fade-left' => esc_html__('Fade Left', 'oworganic'),
                    'fade-right' => esc_html__('Fade Right', 'oworganic'),
                    'fade-up-right' => esc_html__('Fade Up Right', 'oworganic'),
                    'fade-up-left' => esc_html__('Fade Up Left', 'oworganic'),
                    'fade-down-right' => esc_html__('Fade Down Right', 'oworganic'),
                    'fade-down-left' => esc_html__('Fade Down Left', 'oworganic'),
                    'flip-up' => esc_html__('Flip Up', 'oworganic'),
                    'flip-down' => esc_html__('Flip Down', 'oworganic'),
                    'flip-left' => esc_html__('Flip Left', 'oworganic'),
                    'flip-right' => esc_html__('Flip Right', 'oworganic'),
                    'slide-up' => esc_html__('Slide Up', 'oworganic'),
                    'slide-down' => esc_html__('Slide Down', 'oworganic'),
                    'slide-left' => esc_html__('Slide Left', 'oworganic'),
                    'slide-right' => esc_html__('Slide Right', 'oworganic'),
                    'zoom-in' => esc_html__('Zoom In', 'oworganic'),
                    'zoom-in-up' => esc_html__('Zoom In Up', 'oworganic'),
                    'zoom-in-down' => esc_html__('Zoom In Down', 'oworganic'),
                    'zoom-in-left' => esc_html__('Zoom In Left', 'oworganic'),
                    'zoom-in-right' => esc_html__('Zoom In Right', 'oworganic'),
                    'zoom-out' => esc_html__('Zoom Out', 'oworganic'),
                    'zoom-out-up' => esc_html__('Zoom Out Up', 'oworganic'),
                    'zoom-out-down' => esc_html__('Zoom Out Down', 'oworganic'),
                    'zoom-out-left' => esc_html__('Zoom Out Feft', 'oworganic'),
                    'zoom-out-right' => esc_html__('Zoom Out Right', 'oworganic')
                ),
                'default' => ''
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                'selector' => '{{WRAPPER}} .title a, {{WRAPPER}} .title',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($banners) ) {
            $rand_id = oworganic_random_key();
            ?>
            <div class="widget-banners-box <?php echo esc_attr($el_class); ?>">
                <nav id="txtanimation-<?php echo esc_attr($rand_id); ?>" class="txtcollection text-<?php echo esc_attr($alignment); ?>" data-section-type="textanimation" data-section-id="<?php echo esc_attr($rand_id); ?>" data-animation="<?php echo esc_attr($animation); ?>">
                    <?php foreach ($banners as $item):
                        if ( ! empty( $item['link']['url'] ) ) {
                            echo '<a class="item__collection item_'.esc_attr($rand_id).'" href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>';
                        } else {
                            echo '<a class="item__collection item_'.esc_attr($rand_id).'" href="#">';
                        }
                    ?>
                            <?php echo wp_get_attachment_image($item['image']['id'], 'full', '', array( 'class' => 'img' )); ?>

                            <span class="h2 item__collection-name d-block"><?php echo esc_attr($item['title_text']); ?></span>
                            <?php if ( !empty($item['products_count']) ) { ?>
                                <span class="item__collection-sub font-family-2 text-uppercase d-block">
                                    <?php echo esc_attr($item['products_count']); ?> <?php esc_html_e('Products', 'oworganic'); ?>
                                </span>
                            <?php } ?>
                           
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
            <?php
        }
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Special_Banner );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Special_Banner );
}