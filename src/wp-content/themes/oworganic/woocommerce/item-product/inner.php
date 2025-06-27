<?php 
global $product;
$product_id = $product->get_id();
$image_size = isset($image_size) ? $image_size : 'woocommerce_thumbnail';

?>
<div class="product-block grid" data-product-id="<?php echo esc_attr($product_id); ?>">
    <div class="grid-inner">
        <div class="block-inner">
            <figure class="image">
                <?php
                    oworganic_product_image($image_size);
                    do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
            </figure>
            <div class="wishlist-compare-wrapper flex flex-column">

                <?php
                    if ( class_exists( 'YITH_WCWL' ) ) {
                        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                    } elseif ( oworganic_is_woosw_activated() && get_option('woosw_button_position_archive') == "0" ) {
                        echo do_shortcode('[woosw]');
                    }
                ?>
                <?php if( class_exists( 'YITH_Woocompare_Frontend' ) ) { ?>
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
                    <div class="yith-compare hidden-xs">
                        <a title="<?php esc_attr_e('compare', 'oworganic') ?>" href="<?php echo esc_url( $url ); ?>" class="compare <?php echo esc_attr($compare_class); ?>" data-product_id="<?php echo esc_attr($product_id); ?>">
                            <svg aria-hidden="true" focusable="false" width="18" height="18" data-prefix="far" data-icon="balance-scale" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M256 336h-.02c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49C-2.06 328.75.02 320.33.02 336H0c0 44.18 57.31 80 128 80s128-35.82 128-80zM83.24 265.13c11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H55.83c6.2-12.68 15.24-30.69 27.41-54.87zM528 464H344V155.93c27.42-8.67 48.59-31.36 54.39-59.93H528c8.84 0 16-7.16 16-16V64c0-8.84-7.16-16-16-16H393.25C380.89 19.77 352.79 0 320 0s-60.89 19.77-73.25 48H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h129.61c5.8 28.57 26.97 51.26 54.39 59.93V464H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zM320 112c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm319.98 224c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49-87.12 174.26-85.04 165.84-85.04 181.51H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02zm-200.15-16c6.19-12.68 15.23-30.69 27.4-54.87 11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H439.83z" class=""></path></svg>
                        </a>
                    </div>
                <?php } elseif( oworganic_is_woosc_activated() && get_option('woosc_button_archive') == "0" ) { ?>
                    <?php echo do_shortcode('[woosc]'); ?>
                <?php } ?>
            </div>
            <div class="add-to-cart-quickview-wrapper">
                <?php if ( oworganic_get_config('show_quickview', false) ) { ?>
                    <div class="view hidden-xs">
                        <a href="javascript:void(0);" class="quickview" data-product_id="<?php echo esc_attr($product_id); ?>">
                            <i class="ti-eye icon-action"></i>
                            <span class="text"><?php esc_html_e('Quickview', 'oworganic'); ?></span>
                        </a>
                    </div>
                <?php } ?>

                <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
            </div>
        </div>
        <div class="metas clearfix">
            <div class="clearfix">
                <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php
                    /**
                    * woocommerce_after_shop_loop_item_title hook
                    *
                    * @hooked woocommerce_template_loop_rating - 5
                    * @hooked woocommerce_template_loop_price - 10
                    */
                    remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5);
                    do_action( 'woocommerce_after_shop_loop_item_title');
                ?>
                
                <?php Oworganic_Woo_Swatches::swatches_list( $image_size ); ?>

            </div>
                
        </div>
    </div>
</div>