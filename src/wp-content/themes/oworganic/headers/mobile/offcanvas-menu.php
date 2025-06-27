<div id="apus-mobile-menu" class="apus-offcanvas hidden-lg"> 
    <div class="apus-offcanvas-body">

        <div class="header-offcanvas">
            <div class="container">
                <div class="row flex-middle">
                    <div class="col-xs-3">
                        <a class="btn-toggle-canvas" data-toggle="offcanvas">
                            <i class="ti-close"></i>
                        </a>
                    </div>

                    <div class="text-center col-xs-6">
                        <?php
                            $logo = oworganic_get_config('media-mobile-logo');
                            $logo_url = '';
                            if ( !empty($logo['id']) ) {
                                $img = wp_get_attachment_image_src($logo['id'], 'full');
                                if ( !empty($img[0]) ) {
                                    $logo_url = $img[0];
                                }
                            }
                        ?>
                        <?php if( isset($logo['url']) && !empty($logo['url']) ): ?>
                            <div class="logo">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="logo logo-theme">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                    <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/logo.svg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ( defined('OWORGANIC_WOOCOMMERCE_ACTIVED') && oworganic_get_config('show_cartbtn') && !oworganic_get_config( 'enable_shop_catalog' ) ): ?>
                        <div class="col-xs-3">
                            <div class="pull-right">
                                <!-- Setting -->
                                <div class="top-cart">
                                    <?php global $woocommerce; ?>
                                    <div class="apus-topcart">
                                        <div class="cart">
                                            <a class="mini-cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e('View your shopping cart', 'oworganic'); ?>">
                                                <svg aria-hidden="true" width="24" height="24" focusable="false" data-prefix="fal" data-icon="shopping-bag" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-cart"><path fill="currentColor" d="M352 128C352 57.421 294.579 0 224 0 153.42 0 96 57.421 96 128H0v304c0 44.183 35.817 80 80 80h288c44.183 0 80-35.817 80-80V128h-96zM224 32c52.935 0 96 43.065 96 96H128c0-52.935 43.065-96 96-96zm192 400c0 26.467-21.533 48-48 48H80c-26.467 0-48-21.533-48-48V160h64v48c0 8.837 7.164 16 16 16s16-7.163 16-16v-48h192v48c0 8.837 7.163 16 16 16s16-7.163 16-16v-48h64v272z" class=""></path></svg>
                                                <span class="count"><?php echo trim($woocommerce->cart->cart_contents_count); ?></span>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <div class="middle-offcanvas">

            <?php
                if ( defined('OWORGANIC_WOOCOMMERCE_ACTIVED') && oworganic_get_config('show_searchform', true) ) {
                    get_template_part('template-parts/productsearchform-nocategory');
                }
            ?>

            <nav id="menu-main-menu-navbar" class="navbar navbar-offcanvas" role="navigation">
                <?php
                    $mobile_menu = 'primary';
                    $menus = get_nav_menu_locations();
                    if( !empty($menus['mobile-primary']) && wp_get_nav_menu_items($menus['mobile-primary'])) {
                        $mobile_menu = 'mobile-primary';
                    }
                    $args = array(
                        'theme_location' => $mobile_menu,
                        'container_class' => '',
                        'menu_class' => '',
                        'fallback_cb' => '',
                        'menu_id' => '',
                        'container' => 'div',
                        'container_id' => 'mobile-menu-container',
                        'walker' => new Oworganic_Mobile_Menu()
                    );
                    wp_nav_menu($args);

                ?>
            </nav>
        </div>

        <?php if ( is_active_sidebar( 'header-mobile-bottom' ) || oworganic_get_config('show_login_register', true) ) { ?>
            <div class="header-mobile-bottom">
                <?php if ( oworganic_get_config('show_login_register', true) ) { ?>
                    <a class="my-account" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                        <?php esc_html_e('My Account', 'oworganic'); ?></a>
                <?php } ?>
            
                <?php if ( is_active_sidebar( 'header-mobile-bottom' ) ){ ?>
                    <?php dynamic_sidebar( 'header-mobile-bottom' ); ?>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
</div>
<div class="over-dark"></div>