<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Woo_Categories extends Widget_Base {

	public function get_name() {
        return 'apus_element_woo_categories';
    }

	public function get_title() {
        return esc_html__( 'Apus Product Categories', 'oworganic' );
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

        $repeater = new Repeater();

        $repeater->add_control(
            'image_icon',
            [
                'label' => esc_html__( 'Image or Icon', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'icon' => esc_html__('Icon', 'oworganic'),
                    'image' => esc_html__('Image', 'oworganic'),
                ),
                'default' => 'image'
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'oworganic' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'image_icon' => 'icon',
                ],
            ]
        );

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
                'condition' => [
                    'image_icon' => 'image',
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
            'title',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'This is the heading', 'oworganic' ),
                'placeholder' => esc_html__( 'Enter your title', 'oworganic' ),
            ]
        );

        $repeater->add_control(
            'slug', [
                'label' => esc_html__( 'Category Slug', 'oworganic' ),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://your-link.com', 'oworganic' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => esc_html__( 'Categories', 'oworganic' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
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
                    'style4' => esc_html__('Style 4', 'oworganic'),
                    'style5' => esc_html__('Style 5', 'oworganic'),
                    'style6' => esc_html__('Style 6', 'oworganic'),
                ),
                'default' => 'style1'
            ]
        );
        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'carousel' => esc_html__('Carousel', 'oworganic'),
                    'grid' => esc_html__('Grid', 'oworganic'),
                ),
                'default' => 'carousel',
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
                'condition' => [
                    'layout_type' => 'carousel',
                ],
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
                    'carousel_2' => esc_html__('Style 2', 'oworganic'),
                    'carousel_vertical carousel_2' => esc_html__('Vertical 2', 'oworganic'),
                    'carousel_white' => esc_html__('White', 'oworganic'),
                    'carousel_circle' => esc_html__('Circle', 'oworganic'),
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

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .item-inner-categories:hover .title' => 'color: {{VALUE}};',
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
            'nb_color',
            [
                'label' => esc_html__( 'Number item Color', 'oworganic' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .product-nb' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Number item Typography', 'oworganic' ),
                'name' => 'nb_typography',
                'selector' => '{{WRAPPER}} .product-nb',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($categories) ) {
            $columns = !empty($columns) ? $columns : 5;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 4;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 2;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
        ?>
            <div class="widget-categories-box <?php echo esc_attr($el_class); ?>">
                <?php if ($layout_type == 'carousel') { ?>
                    
                    <div class="slick-carousel <?php echo esc_attr( ( $columns >= count($categories) )?'hidden-dots':'' ); ?> <?php echo esc_attr($carousel_style); ?>"
                        data-items="<?php echo esc_attr($columns); ?>"
                        data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                        data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                        data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                        data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                        data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                        data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">

                        <?php foreach ($categories as $item):
                            ?>
                            <div class="item">
                            <div class="item-inner-categories <?php echo esc_attr($style); ?>">
                                <?php
                                $html = $link = '';

                                $term = get_term_by('slug', $item['slug'], 'product_cat');
                                if ( $term ) {
                                    $link = get_term_link($term);
                                }
                                if ( ! empty( $item['link'] ) ) {
                                    $link = $item['link'];
                                }
                                if ( $item['image_icon'] == 'image' ) {
                                    if ( ! empty( $item['image']['url'] ) ) {
                                        $this->add_render_attribute( 'image', 'src', $item['image']['url'] );
                                        $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $item['image'] ) );
                                        $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $item['image'] ) );

                                        $image_html = Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image' );

                                        if ( ! empty( $link ) ) {
                                            $image_html = '<a href="'.esc_url($link).'">' . $image_html . '</a>';
                                        }

                                        $html .= '<div class="category-box-image img">' . $image_html . '</div>';
                                    }
                                } elseif ( $item['image_icon'] == 'icon' && !empty($item['icon'])) {

                                    $icon_html = '<i class="'.$item['icon'].'"></i>';

                                    if ( ! empty( $link ) ) {
                                        $icon_html = '<a href="'.esc_url($link).'">' . $icon_html . '</a>';
                                    }

                                    $html .= '<div class="category-box-image icon">'.$icon_html.'</div>';
                                }

                                if ( $item['title'] ) {
                                    $html .= '<div class="category-box-content">';

                                    $title_html = $item['title'];

                                    if ( ! empty( $link ) ) {
                                        $html .= '<a href="'.esc_url($link).'"><h3 class="title">'.$title_html.'</h3></a>';
                                    } else {
                                        $html .= sprintf( '<h3 class="title">%1$s</h3>', $title_html );
                                    }

                                    if ( $style == 'style1' && $term ) {
                                        $html .= '<div class="product-nb">'.sprintf(_n('%d Product', '%d Products', $term->count, 'oworganic'), $term->count).'</div>';
                                    }

                                    $html .= '</div>';
                                }

                                echo trim($html);
                                ?>
                            </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } elseif($layout_type == 'grid'){
                    $mdcol = 12/$columns;
                    $smcol = 12/$columns_tablet;
                    $xscol = 12/$columns_mobile;
                ?>  
                    <div class="row">
                        <?php foreach ($categories as $item): ?>
                            <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr($xscol); ?>">
                                <div class="item-inner-categories <?php echo esc_attr($style); ?>">
                                    <?php
                                    $html = $link = '';

                                    $term = get_term_by('slug', $item['slug'], 'product_cat');
                                    if ( $term ) {
                                        $link = get_term_link($term);
                                    }
                                    if ( ! empty( $item['link'] ) ) {
                                        $link = $item['link'];
                                    }
                                    if ( $item['image_icon'] == 'image' ) {
                                        if ( ! empty( $item['image']['url'] ) ) {
                                            $this->add_render_attribute( 'image', 'src', $item['image']['url'] );
                                            $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $item['image'] ) );
                                            $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $item['image'] ) );


                                            $image_html = Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image' );

                                            if ( ! empty( $link ) ) {
                                                $image_html = '<a href="'.esc_url($link).'">' . $image_html . '</a>';
                                            }

                                            $html .= '<div class="category-box-image img">' . $image_html . '</div>';
                                        }
                                    } elseif ( $item['image_icon'] == 'icon' && !empty($item['icon'])) {
                                        $html .= '<div class="category-box-image icon"><i class="'.$item['icon'].'"></i></div>';
                                    }

                                    if ( $item['title'] ) {
                                        $html .= '<div class="category-box-content">';

                                        $title_html = $item['title'];

                                        if ( ! empty( $link ) ) {
                                            $html .= '<a href="'.esc_url($link).'"><h3 class="title">'.$title_html.'</h3></a>';
                                        } else {
                                            $html .= sprintf( '<h3 class="title">%1$s</h3>', $title_html );
                                        }

                                        if ( $style == 'style1' && $term ) {
                                            $html .= '<div class="product-nb">'.sprintf(_n('%d Product', '%d Products', $term->count, 'oworganic'), $term->count).'</div>';
                                        }

                                        $html .= '</div>';
                                    }

                                    echo trim($html);
                                    ?>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
                    
            </div>
            <?php
        }
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Woo_Categories );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Woo_Categories );
}