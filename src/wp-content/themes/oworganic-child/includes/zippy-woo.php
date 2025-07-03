<?php

function products_add_on()
{
    global $product;
    $product_id = $product->get_id();

    if (have_rows('product_add_ons_list', $product_id)) {
        echo '<div class="product-add-ons-list">';

        while (have_rows('product_add_ons_list', $product_id)) : the_row();
            $get_sub_field = get_sub_field('add_on_items');
            $add_on_products = wc_get_product($get_sub_field->ID);

            echo '<div class="add-on-product">';
            woocommerce_quantity_input(
                array(
                    'input_name'  => 'add_on_quantity[' . $add_on_products->get_id() . ']',
                    'min_value'   => 0,
                    'max_value'   => $add_on_products->get_max_purchase_quantity(),
                    'input_value' => 0,
                    'classes'     => array('input-text', 'qty', 'text')
                ),
                $add_on_products
            );
            echo '<p class="add-on-product-name ">' . $add_on_products->get_name() . '</p>';
            echo '<p class="add-on-product-price">' . $add_on_products->get_price_html() . '</p>';
            echo '</div>';
            echo '<div class="spacing-line"></div>';
        endwhile;
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'products_add_on');


function product_add_on_add_to_cart()
{
    if (did_action('product_add_on_success') > 0) {
        return;
    }
    do_action('product_add_on_success');
    if (isset($_POST['add_on_quantity']) && is_array($_POST['add_on_quantity'])) {
        foreach ($_POST['add_on_quantity'] as $add_on_id => $add_on_qty) {
            $add_on_qty = intval($add_on_qty);
            if ($add_on_qty > 0) {
                WC()->cart->add_to_cart($add_on_id, $add_on_qty);
            }
        }
    }
}
add_action('woocommerce_add_to_cart', 'product_add_on_add_to_cart');
