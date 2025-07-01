<?php
global $product;
$time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
wp_enqueue_script( 'countdown' );
?>
<?php if ( $time_sale ) { ?>
	<div class="countdown-product">
		<div class="time">
		    <div class="apus-countdown clearfix" data-time="timmer"
		        data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>">
		    </div>
		</div>
	</div>
<?php } ?>