<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Woo_Header_Info extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_woo_header';
    }

    public function get_title() {
        return esc_html__( 'Apus Header Woo Button', 'oworganic' );
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
            'hide_wishlist',
            [
                'label' => esc_html__( 'Wishlist', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'oworganic' ),
                'label_off' => esc_html__( 'Show', 'oworganic' ),
            ]
        );

        $this->add_control(
            'hide_cart',
            [
                'label' => esc_html__( 'Cart', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'oworganic' ),
                'label_off' => esc_html__( 'Show', 'oworganic' ),
            ]
        );

        $this->add_control(
            'mini_cart',
            [
                'label' => esc_html__( 'Mini Cart Layout', 'oworganic' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => [
                    'offcanvas' => esc_html__( 'Offcanvas', 'oworganic' ),
                    'dropdown_box' => esc_html__( 'Dropdown Box', 'oworganic' ),
                ],
                'default' => 'dropdown_box'
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'oworganic' ),
                'type' => Elementor\Controls_Manager::CHOOSE,
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
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon', 'oworganic' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .wishlist-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mini-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__( 'Color Count', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_count_color',
            [
                'label' => esc_html__( 'Bg Count', 'oworganic' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        $add_class = '';
        if ( !empty($align) ) {
            $add_class = 'menu-'.$align;
        }
        ?>
        <div class="header-button-woo clearfix <?php echo esc_attr($add_class.' '.$el_class); ?>">
            <?php
            global $woocommerce;
            if ( $hide_cart && is_object($woocommerce) && is_object($woocommerce->cart) ) {
            ?>
                <div class="pull-right">
                    <div class="apus-topcart">
                        <div class="cart">
                            <?php if ( $mini_cart == 'dropdown_box' ) { ?>
                                <a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" href="#" title="<?php esc_attr_e('View your shopping cart', 'oworganic'); ?>">
                                    <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-cart"><path fill="currentColor" d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z" class=""></path></svg>
                                    <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="widget_shopping_cart_content">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <a class="offcanvas mini-cart" href="#" title="<?php esc_attr_e('View your shopping cart', 'oworganic'); ?>">
                                    <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-cart"><path fill="currentColor" d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z" class=""></path></svg>
                                    <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                                <div class="offcanvas-content">
                                    <h3 class="title-cart-canvas"><i class="ti-close close-cart"></i> <?php echo esc_html__(' Your Cart', 'oworganic'); ?></h3>
                                    <div class="widget_shopping_cart_content">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                                <div class="overlay-offcanvas-content"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                ?>
                <div class="pull-right">
                    <div class="apus-topcart">
                        <div class="cart">
                            <a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" href="#" title="<?php esc_attr_e('View your shopping cart', 'oworganic'); ?>">
                                <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-cart"><path fill="currentColor" d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z" class=""></path></svg>
                                <span class="count">0</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
            }

            if ( $hide_wishlist && class_exists( 'YITH_WCWL' ) ) {
                $wishlist_url = YITH_WCWL()->get_wishlist_url();
            ?>
                <div class="pull-right">
                    <a class="wishlist-icon" href="<?php echo esc_url($wishlist_url);?>">
                        <i class="flaticon-heart"></i>
                        <?php if ( function_exists('yith_wcwl_count_products') ) { ?>
                            <span class="count"><?php echo yith_wcwl_count_products(); ?></span>
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Woo_Header_Info );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Woo_Header_Info );
}