<?php

defined( 'ABSPATH' ) || exit;

global $post;
wp_enqueue_script( 'wc-add-to-cart-variation' );

?>
<div class="woocommerce">
    <div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
        <div id="single-product" class="single-product product-info details-product">
            <div class="row">
                
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="information-wrapper">
                        <div class="information">
                            <?php
                                /**
                                * woocommerce_single_product_summary hook
                                *
                                * @hooked woocommerce_template_single_title - 5
                                * @hooked woocommerce_template_single_rating - 10
                                * @hooked woocommerce_template_single_price - 10
                                * @hooked woocommerce_template_single_excerpt - 20
                                * @hooked woocommerce_template_single_add_to_cart - 30
                                * @hooked woocommerce_template_single_meta - 40
                                * @hooked woocommerce_template_single_sharing - 50
                                */
                                echo '<div class="top-info-detail clearfix">';
                                oworganic_woo_display_product_cat($post->ID);
                                woocommerce_template_single_title();
                                woocommerce_template_single_rating();
                                echo '</div>';
                                woocommerce_template_single_excerpt();

                                woocommerce_template_single_price();

                                if ( !oworganic_get_config( 'enable_shop_catalog' ) ) {
                                    woocommerce_template_single_add_to_cart();
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 gallery-wrapper">
                    <div class="wrapper-img-main">
                        <?php
                            if ( has_post_thumbnail() ) {
                                $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                                echo trim(oworganic_wc_get_gallery_image_html( $post_thumbnail_id, true ));
                            }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>