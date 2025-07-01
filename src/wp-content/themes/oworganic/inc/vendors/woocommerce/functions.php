<?php

if ( !function_exists('oworganic_get_products') ) {
    function oworganic_get_products( $args = array() ) {
        global $woocommerce, $wp_query;

        $args = wp_parse_args( $args, array(
            'categories' => array(),
            'product_type' => 'recent_product',
            'paged' => 1,
            'post_per_page' => -1,
            'orderby' => '',
            'order' => '',
            'includes' => array(),
            'excludes' => array(),
            'author' => '',
            'fields' => ''
        ));
        extract($args);
        
        $query_args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'orderby'   => $orderby,
            'order' => $order
        );

        if ( $fields ) {
            $query_args['fields'] = $fields;
        }
        
        if ( isset( $query_args['orderby'] ) ) {
            if ( 'price' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_price',
                    'orderby'   => 'meta_value_num'
                ) );
            }
            if ( 'featured' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_featured',
                    'orderby'   => 'meta_value'
                ) );
            }
            if ( 'sku' == $query_args['orderby'] ) {
                $query_args = array_merge( $query_args, array(
                    'meta_key'  => '_sku',
                    'orderby'   => 'meta_value'
                ) );
            }
        }

        switch ($product_type) {
            case 'best_selling':
                $query_args['meta_key']='total_sales';
                $query_args['orderby']='meta_value_num';
                $query_args['ignore_sticky_posts']   = 1;
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                );
                break;
            case 'top_rate':
                //add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recent_product':
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'deals':
                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $query_args['meta_query'][] =  array(
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    )
                );
                break;     
            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
            case 'recent_review':
                if($post_per_page == -1) $_limit = 4;
                else $_limit = $post_per_page;
                global $wpdb;
                $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c
                        WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0
                        ORDER BY c.comment_date ASC";
                $results = $wpdb->get_results($query, OBJECT);
                $_pids = array();
                foreach ($results as $re) {
                    if(!in_array($re->comment_post_ID, $_pids))
                        $_pids[] = $re->comment_post_ID;
                    if(count($_pids) == $_limit)
                        break;
                }

                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $query_args['post__in'] = $_pids;

                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            case 'recommended':

                $query_args['meta_query'] = array();
                $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $query_args['meta_query'][] = array(
                    'key' => '_apus_recommended',
                    'value' => 'yes',
                );
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recently_viewed':
                $viewed_products = ! empty( $_COOKIE['apus_woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['apus_woocommerce_recently_viewed'] ) : array();
                $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

                if ( empty( $viewed_products ) ) {
                    return false;
                }
                $query_args['post__in'] = $viewed_products;
                break;
        }

        if ( !empty($categories) && is_array($categories) ) {
            $query_args['tax_query'][] = array(
                'taxonomy'      => 'product_cat',
                'field'         => 'slug',
                'terms'         => $categories,
                'operator'      => 'IN'
            );
        }

        if (!empty($includes) && is_array($includes)) {
            $query_args['post__in'] = $includes;
        }
        
        if ( !empty($excludes) && is_array($excludes) ) {
            $query_args['post__not_in'] = $excludes;
        }

        if ( !empty($author) ) {
            $query_args['author'] = $author;
        }
        if ( $product_type == 'top_rate' && class_exists('WC_Shortcode_Products') ) {
            add_filter( 'posts_clauses', array( 'WC_Shortcode_Products', 'order_by_rating_post_clauses' ) );
            $loop = new WP_Query($query_args);
            call_user_func( implode('_', array('remove', 'filter')), 'posts_clauses', array( 'WC_Shortcode_Products', 'order_by_rating_post_clauses' ) );
        } else {
            $loop = new WP_Query($query_args);
        }
        return $loop;
    }
}

// add product viewed
function oworganic_track_product_view() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }

    global $post;

    if ( empty( $_COOKIE['apus_woocommerce_recently_viewed'] ) )
        $viewed_products = array();
    else
        $viewed_products = (array) explode( '|', $_COOKIE['apus_woocommerce_recently_viewed'] );

    if ( ! in_array( $post->ID, $viewed_products ) ) {
        $viewed_products[] = $post->ID;
    }

    if ( sizeof( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }

    // Store for session only
    wc_setcookie( 'apus_woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
add_action( 'template_redirect', 'oworganic_track_product_view', 20 );

function oworganic_woocommerce_enqueue_scripts() {
    wp_enqueue_script( 'selectWoo' );
    wp_enqueue_style( 'select2' );
    
    wp_register_script( 'sticky-kit', get_template_directory_uri() . '/js/sticky-kit.min.js', array( 'jquery' ), '20150330', true );

    wp_enqueue_script( 'oworganic-quantity-increment', get_template_directory_uri() . '/js/wc-quantity-increment.js', array( 'jquery' ), '20150330', true );
    wp_register_script( 'oworganic-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array( 'jquery', 'jquery-unveil', 'slick' ), '20150330', true );

    $ajax_url = add_query_arg( 'wc-ajax', '%%endpoint%%', trailingslashit( site_url() ) );

    $options = array(
        'ajaxurl' => $ajax_url,
        'enable_search' => (oworganic_get_config('enable_autocompleate_search', true) ? '1' : '0'),
        'empty_msg' => apply_filters( 'oworganic_autocompleate_search_empty_msg', esc_html__( 'Unable to find any products that match the currenty query', 'oworganic' ) ),
        'conpare_text' => esc_html__('Added Compare', 'oworganic'),
        'nonce' => wp_create_nonce( 'ajax-nonce' ),
        '_preset' => oworganic_get_demo_preset()
    );
    wp_localize_script( 'oworganic-woocommerce', 'oworganic_woo_opts', $options );
    wp_enqueue_script( 'oworganic-woocommerce' );
    
    if (oworganic_get_config('show_quickview', false)) {
        wp_enqueue_script( 'wc-add-to-cart-variation' );
    }
}
add_action( 'wp_enqueue_scripts', 'oworganic_woocommerce_enqueue_scripts', 10 );

// cart
if ( !function_exists('oworganic_woocommerce_header_add_to_cart_fragment') ) {
    function oworganic_woocommerce_header_add_to_cart_fragment( $fragments ){
        global $woocommerce;
        $fragments['.cart .count'] =  ' <span class="count"> '. $woocommerce->cart->cart_contents_count .' </span> ';
        $fragments['.footer-mini-cart .count'] =  ' <span class="count"> '. $woocommerce->cart->cart_contents_count .' </span> ';
        $fragments['.cart .total-minicart'] = '<div class="total-minicart">'. $woocommerce->cart->get_cart_total(). '</div>';
        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'oworganic_woocommerce_header_add_to_cart_fragment' );

// breadcrumb for woocommerce page
if ( !function_exists('oworganic_woocommerce_breadcrumb_defaults') ) {
    function oworganic_woocommerce_breadcrumb_defaults( $args ) {
        $breadcrumb_img = oworganic_get_config('woo_breadcrumb_image');
        $breadcrumb_color = oworganic_get_config('woo_breadcrumb_color');
        $style = $classes = array();
        $show_breadcrumbs = oworganic_get_config('show_product_breadcrumbs', true);

        if ( !$show_breadcrumbs ) {
            $style[] = 'display:none';
        }
        if( $breadcrumb_color  ){
            $style[] = 'background-color:'.$breadcrumb_color;
        }
        
        if ( !empty($breadcrumb_img['id']) ) {
            $img = wp_get_attachment_image_src($breadcrumb_img['id'], 'full');
            if ( !empty($img[0]) ) {
                $style[] = 'background-image:url(\''.esc_url($img[0]).'\')';
                $classes[] = 'has_bg';
            }
        }

        $estyle = !empty($style) ? ' style="'.implode(";", $style).'"':"";
        if ( is_single() ) {
            $classes[] = 'woo-detail';
        }

        $full_width = apply_filters('oworganic_woocommerce_content_class', 'clearfix');
        
        // check woo
        if(is_product()){
            $title = '';
        }else{
            $title = '<div class="breadscrumb-inner hidden-icon"><h2 class="bread-title">'.esc_html__( 'Shop', 'oworganic' ).'</h2></div>';
        }

        $args['wrap_before'] = '<section id="apus-breadscrumb" class="apus-breadscrumb woo-breadcrumb '.esc_attr(!empty($classes) ? implode(' ', $classes) : '').'"'.$estyle.'><div class="'.$full_width.'"><div class="wrapper-breads"><div class="wrapper-breads-inner">'.$title.'
        <ol class="breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
        $args['wrap_after'] = '</ol></div></div></div></section>';

        return $args;
    }
}
add_filter( 'woocommerce_breadcrumb_defaults', 'oworganic_woocommerce_breadcrumb_defaults' );
add_action( 'oworganic_woo_template_main_before', 'woocommerce_breadcrumb', 30, 0 );


// display woocommerce modes
if ( !function_exists('oworganic_woocommerce_display_modes') ) {
    function oworganic_woocommerce_display_modes(){
        global $wp;
        $current_url = oworganic_shop_page_link(true);

        $url_grid = add_query_arg( 'display_mode', 'grid', remove_query_arg( 'display_mode', $current_url ) );
        $url_list = add_query_arg( 'display_mode', 'list', remove_query_arg( 'display_mode', $current_url ) );

        $woo_mode = oworganic_woocommerce_get_display_mode();

        echo '<div class="display-mode pull-right">';
        echo '<a href="'.  $url_grid  .'" class=" change-view '.($woo_mode == 'grid' ? 'active' : '').'"><i class="ti-layout-grid3"></i></a>';
        echo '<a href="'.  $url_list  .'" class=" change-view '.($woo_mode == 'list' ? 'active' : '').'"><i class="ti-view-list-alt"></i></a>';
        echo '</div>'; 
    }
}

if ( !function_exists('oworganic_woocommerce_get_display_mode') ) {
    function oworganic_woocommerce_get_display_mode() {
        $woo_mode = oworganic_get_config('product_display_mode', 'grid');
        $args = array( 'grid', 'list' );
        if ( isset($_COOKIE['oworganic_woo_mode']) && in_array($_COOKIE['oworganic_woo_mode'], $args) ) {
            $woo_mode = $_COOKIE['oworganic_woo_mode'];
        }
        return $woo_mode;
    }
}

function oworganic_before_woocommerce_init() {
    // set display mode to cookie
    if( isset($_GET['display_mode']) && ($_GET['display_mode']=='list' || $_GET['display_mode']=='grid') ){  
        setcookie( 'oworganic_woo_mode', sanitize_text_field($_GET['display_mode']) , time()+3600*24*100,'/' );
        $_COOKIE['oworganic_woo_mode'] = sanitize_text_field($_GET['display_mode']);
    }
}
add_action( 'init', 'oworganic_before_woocommerce_init' );

function oworganic_shop_page_link($keep_query = false ) {
    if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
        $link = home_url();
    } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
        $link = get_post_type_archive_link( 'product' );
    } else {
        $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
    }

    if( $keep_query ) {
        // Keep query string vars intact
        foreach ( $_GET as $key => $val ) {
            if ( 'orderby' === $key || 'submit' === $key ) {
                continue;
            }
            $link = add_query_arg( $key, $val, $link );

        }
    }
    return $link;
}

// add filter to top archive
add_action( 'woocommerce_top_pagination', 'woocommerce_pagination', 1 );


add_action( 'wc_ajax_oworganic_ajax_get_products', 'oworganic_woocommerce_get_ajax_products' );
function oworganic_woocommerce_get_ajax_products() {
    $settings = isset($_POST['settings']) ? $_POST['settings'] : '';

    $tab = isset($_POST['tab']) ? $_POST['tab'] : '';
    
    if ( empty($settings) || empty($tab) ) {
        exit();
    }

    $woo_product_tabs_special = !empty($settings['woo_product_tabs_special']) ? true : false;

    $slugs = !empty($tab['slugs']) ? array_map('trim', explode(',', $tab['slugs'])) : array();

    $columns = isset($settings['columns']) ? $settings['columns'] : 4;
    $columns_tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : 4;
    $columns_mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : 4;
    $slides_to_scroll = isset($settings['slides_to_scroll']) ? $settings['slides_to_scroll'] : 4;
    $slides_to_scroll_tablet = isset($settings['slides_to_scroll_tablet']) ? $settings['slides_to_scroll_tablet'] : 4;
    $slides_to_scroll_mobile = isset($settings['slides_to_scroll_mobile']) ? $settings['slides_to_scroll_mobile'] : 4;
    $autoplay = isset($settings['autoplay']) ? $settings['autoplay'] : false;
    $infinite_loop = isset($settings['infinite_loop']) ? $settings['infinite_loop'] : false;
    $product_item = isset($settings['product_item']) ? $settings['product_item'] : false;

    $rows = isset($settings['rows']) ? $settings['rows'] : 1;
    $show_nav = isset($settings['show_nav']) ? $settings['show_nav'] : false;
    $show_pagination = isset($settings['show_pagination']) ? $settings['show_pagination'] : false;
    $limit = isset($settings['limit']) ? $settings['limit'] : 4;
    $product_type = isset($tab['type']) ? $tab['type'] : 'recent_product';

    $layout_type = isset($settings['layout_type']) ? $settings['layout_type'] : 'grid';

    $excludes = array();
    $args = array(
        'categories' => $slugs,
        'product_type' => $product_type,
        'paged' => 1,
        'post_per_page' => $limit,
        'excludes' => $excludes,
    );

    $loop = oworganic_get_products( $args );
    if ( $loop->have_posts() ) {
        $max_pages = $loop->max_num_pages;
        wc_get_template( 'layout-products/'.$layout_type.'.php' , array(
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
        ) );
    }

    exit();
}

// quickview
add_action( 'wc_ajax_oworganic_quickview_product', 'oworganic_woocommerce_quickview' );
if ( !function_exists('oworganic_woocommerce_quickview') ) {
    function oworganic_woocommerce_quickview() {
        if ( !empty($_GET['product_id']) ) {
            $post_object = get_post( $_GET['product_id'] );
            if ( $post_object ) {
                setup_postdata( $GLOBALS['post'] =& $post_object );

                wc_get_template_part( 'content', 'product-quickview' );
            }
            wp_reset_postdata();
        }
        die;
    }
}

// Number of products per page
if ( !function_exists('oworganic_woocommerce_shop_per_page') ) {
    function oworganic_woocommerce_shop_per_page($number) {
        if (!is_admin()) {
            if ( isset( $_REQUEST['wppp_ppp'] ) ) :
                $number = intval( $_REQUEST['wppp_ppp'] );
                WC()->session->set( 'products_per_page', intval( $_REQUEST['wppp_ppp'] ) );
            elseif ( isset( $_REQUEST['ppp'] ) ) :
                $number = intval( $_REQUEST['ppp'] );
                WC()->session->set( 'products_per_page', intval( $_REQUEST['ppp'] ) );
            elseif ( WC()->session->__isset( 'products_per_page' ) ) :
                $number = intval( WC()->session->__get( 'products_per_page' ) );
            else :
                $value = oworganic_get_config('number_products_per_page', 12);
                $number = intval( $value );
            endif;
        }
        return $number;

    }
}
add_filter( 'loop_shop_per_page', 'oworganic_woocommerce_shop_per_page', 30 );

// Number of products per row
if ( !function_exists('oworganic_woocommerce_shop_columns') ) {
    function oworganic_woocommerce_shop_columns($number) {
        $value = oworganic_get_config('product_columns');
        if ( in_array( $value, array(1, 2, 3, 4, 5, 6, 7, 8) ) ) {
            $number = $value;
        }
        return $number;
    }
}
add_filter( 'loop_shop_columns', 'oworganic_woocommerce_shop_columns' );

// share box
if ( !function_exists('oworganic_woocommerce_share_box') ) {
    function oworganic_woocommerce_share_box() {
        if ( oworganic_get_config('show_product_social_share', false) ) {
            get_template_part( 'template-parts/sharebox' );
        }
    }
}

function oworganic_woocomerce_wishlist_share_wrapper_open( $value='' ){
    echo '<div class="clearfix wishlist-share-wrapper">';
}

function oworganic_woocomerce_wishlist_share_wrapper_close() {
    echo '</div>';
}


// add div top infor for detail
function oworganic_woo_clearfix_addcart() {
    ?>
    <div class="clearfix"></div>
    <?php
}

add_filter( 'woocommerce_single_product_summary', 'oworganic_woo_clearfix_addcart', 39 );

function oworganic_product_get_layout_type() {
    global $post;
    $layout = get_post_meta($post->ID, 'apus_product_layout_type', true);
                    
    if ( empty($layout) ) {
        $layout = oworganic_get_config('product_single_version', 'v1');
    }
    return $layout;
}


function oworganic_woo_display_product_cat($product_id) {
    $terms = get_the_terms( $product_id, 'product_cat' );
    if ( !empty($terms) && !empty($terms[0]) ) { ?>
        <div class="product-cat">
        <?php
            $term = $terms[0];
            echo '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>';
        ?>
        </div>
    <?php
    }
}


// Wishlist
add_filter( 'yith_wcwl_add_to_wishlist_icon_html', 'oworganic_woocomerce_icon_wishlist'  );
function oworganic_woocomerce_icon_wishlist(){
    return '<i class="ti-heart"></i>';
}
function oworganic_yith_wcwl_positions($positions) {
    if ( isset($positions['add-to-cart']['hook']) ) {
        $positions['add-to-cart']['hook'] = 'woocommerce_single_product_summary';
        $positions['add-to-cart']['priority'] = 35;
    }
    return $positions;
}
add_filter( 'yith_wcwl_positions', 'oworganic_yith_wcwl_positions', 100 );

// countdown
function oworganic_woocommerce_single_countdown() {
    if ( oworganic_get_config('show_product_countdown_timer') ) {
        get_template_part( 'woocommerce/single-product/countdown' );
    }
}
add_action('woocommerce_single_product_summary', 'oworganic_woocommerce_single_countdown', 21);

// swap effect
if ( !function_exists('oworganic_swap_images') ) {
    function oworganic_swap_images() {
        $thumb = apply_filters('oworganic_swap_images_thumb', 'woocommerce_thumbnail');
        $swap_image = (bool)oworganic_get_config('enable_swap_image', true);
        ?>
        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="product-image">
            <?php oworganic_product_get_image($thumb, $swap_image); ?>
        </a>
        <?php
    }
}
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

if ( !function_exists('oworganic_product_image') ) {
    function oworganic_product_image($thumb = 'woocommerce_thumbnail') {
        $swap_image = (bool)oworganic_get_config('enable_swap_image', true);
        ?>
        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="product-image">
            <?php oworganic_product_get_image($thumb, $swap_image); ?>
        </a>
        <?php
    }
}
// get image
if ( !function_exists('oworganic_product_get_image') ) {
    function oworganic_product_get_image($thumb = 'woocommerce_thumbnail', $swap = true) {
        global $post, $product, $woocommerce;
        
        $output = '';
        $class = "attachment-$thumb size-$thumb image-no-effect";
        if (has_post_thumbnail()) {
            if ( $swap ) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids && isset($attachment_ids[0])) {
                    $class = "attachment-$thumb size-$thumb image-hover";
                    $swap_class = "attachment-$thumb size-$thumb image-effect";
                    $output .= oworganic_get_attachment_thumbnail( $attachment_ids[0], $thumb , false, array('class' => $swap_class), false);
                }
            }
            $output .= oworganic_get_attachment_thumbnail( get_post_thumbnail_id(), $thumb , false, array('class' => $class), false);
        } else {
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'.esc_attr__('Placeholder' , 'oworganic').'" class="'.$class.'"/>';
        }
        echo trim($output);
    }
}
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


function oworganic_wc_get_gallery_image_html_simple( $attachment_id, $main_image = false ) {
    $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    
    
    $img = oworganic_get_attachment_thumbnail($attachment_id, $image_size);
    return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_src[0] ) . '">' . $img . '</a></div>';
}

// layout class for woo page
if ( !function_exists('oworganic_woocommerce_content_class') ) {
    function oworganic_woocommerce_content_class( $class ) {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        if( oworganic_get_config('product_'.$page.'_fullwidth', false) ) {
            return 'container-fluid max-1800';
        }
        return $class;
    }
}
add_filter( 'oworganic_woocommerce_content_class', 'oworganic_woocommerce_content_class' );

// get layout configs
if ( !function_exists('oworganic_get_woocommerce_layout_configs') ) {
    function oworganic_get_woocommerce_layout_configs() {
        $page = 'archive';
        if ( is_singular( 'product' ) ) {
            $page = 'single';
        }
        $left = oworganic_get_config('product_'.$page.'_left_sidebar');
        $right = oworganic_get_config('product_'.$page.'_right_sidebar');
        // check full width
        if( oworganic_get_config('product_'.$page.'_fullwidth') ) {
            $sidebar = 'col-lg-2';
            $main_full = 'col-lg-10';
        }else{
            $sidebar = 'col-lg-3';
            $main_full = 'col-lg-9';
        }
        switch ( oworganic_get_config('product_'.$page.'_layout') ) {
            case 'left-main':
                if ( is_active_sidebar( $left ) ) {
                    $configs['left'] = array( 'sidebar' => $left, 'class' => $sidebar.' col-md-3 col-sm-12 col-xs-12 shop-sidebar-left-wrapper'  );
                    $configs['main'] = array( 'class' => $main_full.' col-md-9 col-sm-12 col-xs-12 has-left' );
                }
                break;
            case 'main-right':
                if ( is_active_sidebar( $right ) ) {
                    $configs['right'] = array( 'sidebar' => $right,  'class' => $sidebar.' col-md-3 col-sm-12 col-xs-12 shop-sidebar-right-wrapper' ); 
                    $configs['main'] = array( 'class' => $main_full.' col-md-9 col-sm-12 col-xs-12 has-right' );
                }
                break;
            case 'main':
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                break;
            default:
                if (is_active_sidebar( 'sidebar-default' ) && !is_shop() && !is_single() ) {
                    $configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
                    $configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12 has-right' );
                } else {
                    $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
                }
                break;
        }

        if ( empty($configs) ) {
            if (is_active_sidebar( 'sidebar-default' ) && !is_shop() && !is_single() ) {
                $configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
                $configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12 has-right' );
            } else {
                $configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
            }
        }

        return $configs; 
    }
}

if ( !function_exists( 'oworganic_product_review_tab' ) ) {
    function oworganic_product_review_tab($tabs) {
        global $post;
        if ( !oworganic_get_config('show_product_review_tab', true) && isset($tabs['reviews']) ) {
            unset( $tabs['reviews'] ); 
        }

        if ( !oworganic_get_config('hidden_product_additional_information_tab', false) && isset($tabs['additional_information']) ) {
            unset( $tabs['additional_information'] ); 
        }
        
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'oworganic_product_review_tab', 90 );


// Loop

function oworganic_show_page_title($return) {
    return false;
}
add_filter( 'woocommerce_show_page_title', 'oworganic_show_page_title', 100 );


if (!function_exists('oworganic_filter_before')) {
    function oworganic_filter_before() {
        echo '<div class="wrapper-fillter"><div class="apus-filter clearfix">';
    }
}

if (!function_exists('oworganic_filter_after')) {
    function oworganic_filter_after() {
        echo '</div></div>';
    }
}

function oworganic_product_filter_sidebar() {
    $layout = oworganic_get_config('product_archive_layout', 'left-main');
    if ( is_active_sidebar( 'shop-filter-sidebar' ) && $layout == 'main' ) { ?>
        <div class="filter-btn-wrapper">
            <a href="javascript:void(0);" class="filter-btn"><i class="ti-filter"></i><?php esc_html_e('Filter', 'oworganic'); ?></a>
            <div class="shop-filter-sidebar-wrapper">
                <div class="shop-filter-sidebar-header">
                    <?php esc_html_e('Filter by', 'oworganic'); ?>
                    <a href="javascript:void(0);" class="close-filter"><i class="ti-close"></i></a>
                </div>
                <div class="content-inner">
                    <?php dynamic_sidebar( 'shop-filter-sidebar' ); ?>
                </div>
            </div>
            <div class="shop-filter-sidebar-overlay"></div>
        </div>
    <?php }
}

function oworganic_filter_colmun_before() {
    ?>
    <div class="wrapper-right">
        <div class="left-inner clearfix">
    <?php
}
function oworganic_filter_colmun_after() {
    ?>
    </div></div>
    <?php
}

function oworganic_woocommerce_before_shop_loop_init() {

    add_action( 'woocommerce_before_shop_loop', 'oworganic_filter_before' , 11 );
    add_action( 'woocommerce_before_shop_loop', 'oworganic_filter_colmun_before', 25 );

    add_action( 'woocommerce_before_shop_loop', 'oworganic_product_filter_sidebar' , 29 );

    add_action( 'woocommerce_before_shop_loop', 'oworganic_filter_colmun_after' , 99 );
    add_action( 'woocommerce_before_shop_loop', 'oworganic_filter_after' , 100 );
    
}
add_action( 'init', 'oworganic_woocommerce_before_shop_loop_init' );

function oworganic_show_sale_percentage_loop() {
    global $product;
     
    if ( $product->is_on_sale() ) {
        if ( ! $product->is_type( 'variable' ) ) {
            $price = $product->get_regular_price();
            $sale = $product->get_sale_price();
            if ( $sale && $price ) {
                $max_percentage = ( ( $price - $sale ) / $price ) * 100;
            }
        } else {
            $max_percentage = 0;
            foreach ( $product->get_children() as $child_id ) {
                $variation = wc_get_product( $child_id );
                $price = $variation->get_regular_price();
                $sale = $variation->get_sale_price();
                $percentage = 0;
                if ( $price != 0 && ! empty( $sale ) ) {
                    $percentage = ( $price - $sale ) / $price * 100;
                }
                if ( $percentage > $max_percentage ) {
                    $max_percentage = $percentage;
                }
            }
        }
        if ( !empty($max_percentage) ) {
            echo "<div class='sale-perc'>-" . round($max_percentage) . "%</div>";
        }
    }
 
}
add_action( 'woocommerce_before_shop_loop_item_title', 'oworganic_show_sale_percentage_loop', 25 );
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

function oworganic_display_out_of_stock() {
    global $product;
    if ( ! $product->is_in_stock() ) {
        echo '<p class="stock out-of-stock">'.esc_html__('SOLD OUT', 'oworganic').'</p>';
    }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'oworganic_display_out_of_stock', 10 );


// catalog mode
add_action( 'wp', 'oworganic_catalog_mode_init' );
add_action( 'wp', 'oworganic_pages_redirect' );

function oworganic_catalog_mode_init() {
    if( ! oworganic_get_config( 'enable_shop_catalog' ) ) return false;

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

function oworganic_pages_redirect() {
    if( ! oworganic_get_config( 'enable_shop_catalog' ) ) return false;

    $cart     = is_page( wc_get_page_id( 'cart' ) );
    $checkout = is_page( wc_get_page_id( 'checkout' ) );

    wp_reset_postdata();

    if ( $cart || $checkout ) {
        wp_redirect( home_url() );
        exit;
    }
}

function oworganic_wc_get_gallery_image_html( $attachment_id, $main_image = false ) {
    $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    $alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
    $image             = wp_get_attachment_image(
        $attachment_id,
        $image_size,
        false,
        apply_filters(
            'woocommerce_gallery_image_html_attachment_image_params',
            array(
                'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                'data-src'                => esc_url( $full_src[0] ),
                'data-large_image'        => esc_url( $full_src[0] ),
                'data-large_image_width'  => esc_attr( $full_src[1] ),
                'data-large_image_height' => esc_attr( $full_src[2] ),
                'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
            ),
            $attachment_id,
            $image_size,
            $main_image
        )
    );

    return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_src[0] ) . '" data-elementor-lightbox-slideshow="product-gallery">' . $image . '</a></div>';
}

add_filter( 'woocommerce_single_product_photoswipe_options', 'oworganic_woocommerce_single_product_photoswipe_options');
function oworganic_woocommerce_single_product_photoswipe_options($options){
    $options['captionEl'] = false;
    return $options;
}

function oworganic_woocommerce_init(){
    global $yith_woocompare;
    if ( empty($yith_woocompare->obj) || ! $yith_woocompare->obj instanceof YITH_Woocompare_Frontend ){
        return;
    }
    remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
}
add_action( 'init', 'oworganic_woocommerce_init', 10 );

function oworganic_product_add_compare_link() {
    if( class_exists( 'YITH_Woocompare_Frontend' ) ) {
        global $post;
        $product_id = $post->ID;
        ?>
        <?php
            $obj = new YITH_Woocompare_Frontend();
            $url = $obj->add_product_url($product_id);
            $compare_class = '';
            if ( isset($_COOKIE['yith_woocompare_list']) ) {
                $compare_ids = json_decode( $_COOKIE['yith_woocompare_list'] );
                if ( in_array($product_id, $compare_ids) ) {
                    $compare_class = 'added';
                    $url = $obj->view_table_url($product_id);
                }
            }
        ?>
        <div class="yith-compare">
            <a title="<?php esc_attr_e('compare', 'oworganic') ?>" href="<?php echo esc_url( $url ); ?>" class="compare button-single <?php echo esc_attr($compare_class); ?>" data-product_id="<?php echo esc_attr($product_id); ?>">
                <svg aria-hidden="true" focusable="false" width="18" height="18" data-prefix="far" data-icon="balance-scale" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M256 336h-.02c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49C-2.06 328.75.02 320.33.02 336H0c0 44.18 57.31 80 128 80s128-35.82 128-80zM83.24 265.13c11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H55.83c6.2-12.68 15.24-30.69 27.41-54.87zM528 464H344V155.93c27.42-8.67 48.59-31.36 54.39-59.93H528c8.84 0 16-7.16 16-16V64c0-8.84-7.16-16-16-16H393.25C380.89 19.77 352.79 0 320 0s-60.89 19.77-73.25 48H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h129.61c5.8 28.57 26.97 51.26 54.39 59.93V464H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zM320 112c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm319.98 224c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49-87.12 174.26-85.04 165.84-85.04 181.51H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02zm-200.15-16c6.19-12.68 15.23-30.69 27.4-54.87 11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H439.83z" class=""></path></svg>
                
                <span class="text">
                    <?php esc_html_e('Compare', 'oworganic'); ?>
                </span>

            </a>
        </div>
    <?php }
}
add_action( 'woocommerce_single_product_summary', 'oworganic_product_add_compare_link', 35 );


add_filter( 'woosc_button_position_archive_default', 'oworganic_woosc_button_position_archive_default' );
function oworganic_woosc_button_position_archive_default($return) {
    return '';
}

add_filter( 'woosw_button_position_archive_default', 'oworganic_woosw_button_position_archive_default' );
function oworganic_woosw_button_position_archive_default($return) {
    return '';
}