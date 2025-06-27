<?php
$rand_id = oworganic_random_key();
?>
<div class="user">
	<div id="customer_login_<?php echo esc_attr($rand_id); ?>" class="register_login_wrapper">
		<h2 class="title"><?php esc_html_e( 'Login', 'oworganic' ); ?></h2>
		<form method="post" class="login" role="form">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-group form-row form-row-wide">
				<input type="text" placeholder="<?php esc_attr_e( 'Username or Email *', 'oworganic' ); ?>" class="form-control" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="form-group form-row form-row-wide">
				<input class="form-control" placeholder="<?php esc_attr_e( 'Password *', 'oworganic' ); ?>" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="form-group form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<div class="form-group clearfix">
					<span class="inline pull-left">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'oworganic' ); ?>
					</span>
					<span class="lost_password pull-right">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'oworganic' ); ?></a>
					</span>
				</div>
				<input type="submit" class="btn btn-theme btn-block" name="login" value="<?php esc_html_e( 'LOG IN', 'oworganic' ); ?>" />
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
			<div class="create text-center">
				<?php echo esc_html__('No account yet?','oworganic') ?> <a class="creat-account" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>?ac=register"><?php echo esc_html__('Create an account','oworganic'); ?></a>
			</div>
		<?php endif; ?>

	</div>
</div>