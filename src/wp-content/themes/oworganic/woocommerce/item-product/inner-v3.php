<?php 
global $product;
$product_id = $product->get_id();
$image_size = isset($image_size) ? $image_size : 'woocommerce_thumbnail';

?>
<div class="product-block grid grid-v3" data-product-id="<?php echo esc_attr($product_id); ?>">
    <div class="grid-inner">
        <div class="block-inner">
            <figure class="image">
                <?php
                    oworganic_product_image($image_size);
                    do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
            </figure>
            <div class="wishlist-compare-wrapper">
                <?php
                    if ( class_exists( 'YITH_WCWL' ) ) {
                        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                    } elseif ( oworganic_is_woosw_activated() && get_option('woosw_button_position_archive') == "0" ) {
                        echo do_shortcode('[woosw]');
                    }
                ?>
            </div>
            <div class="quickview-wrapper">
                <?php if ( oworganic_get_config('show_quickview', false) ) { ?>
                    <div class="view">
                        <a href="javascript:void(0);" class="quickview" data-product_id="<?php echo esc_attr($product_id); ?>">
                            <svg aria-hidden="true" width="11" height="11" focusable="false" data-prefix="fal" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-plus fa-w-12 fa-3x"><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z" class=""></path></svg>
                            <span class="text"><?php esc_html_e('Quickview', 'oworganic'); ?></span>
                        </a>
                    </div>
                <?php } ?>
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