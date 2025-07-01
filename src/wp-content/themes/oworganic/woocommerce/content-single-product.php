<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;


/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$layout = oworganic_product_get_layout_type();
$thumbs_pos = oworganic_get_config('product_thumbs_position', 'thumbnails-bottom');
if( oworganic_get_config('show_product_social_share', false) ){
    add_filter( 'woocommerce_single_product_summary', 'oworganic_woocommerce_share_box', 38 );
}

?>
	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'details-product layout-'.$layout, $product ); ?>>
		
		<?php
	        // sticky
	        $main_class = $sticky_class = '';
	        if ( in_array($layout, array('v2', 'v4', 'v5')) ) {
	        	if ( oworganic_get_config('enable_sticky_cart', true) ) {
		        	wp_enqueue_script( 'sticky-kit' );
		        	$main_class = 'product-v-wrapper';
		        	$sticky_class = 'sticky-this';
		        }
	        }
		?>
		<div class="top-content">

			<div class="row top-row <?php echo esc_attr($main_class); ?>">
				<div class="col-md-6 col-xs-12">
					<div class="image-mains clearfix <?php echo esc_attr($thumbs_pos); ?>">
						<?php
							/**
							 * woocommerce_before_single_product_summary hook
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
						?>
					</div>
				</div>
				<div class="col-md-6 col-xs-12 right-info <?php echo esc_attr($sticky_class); ?>">
					<div class="information">
						<div class="summary entry-summary">
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

								remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

								if ( oworganic_get_config('show_product_review_tab', true) ) {
									add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
								}
								
								do_action( 'woocommerce_single_product_summary' );
							?>
						</div><!-- .summary -->
					</div>
				</div>
			</div>

		</div>


		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */

			do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />
		

	</div><!-- #product-<?php the_ID(); ?> -->

	<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>