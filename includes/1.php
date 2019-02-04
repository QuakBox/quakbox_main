<?php
function checkFreeSampleGetProductId($id)
{
    global $wpdb;
    $sql = "SELECT meta_key, meta_value FROM wp_woocommerce_order_itemmeta WHERE (meta_key='pa_free-sample' OR meta_key='_product_id') AND order_item_id=".intval($id);
    $rows = $wpdb->get_results($sql);

    if(empty($rows)){
        return false;
    }

    $productID = false;
    foreach ($rows as $row) {
        if($row->meta_key == 'pa_free-sample' && $row->meta_value != 'yes') {
            return false;
        } else if($row->meta_key == '_product_id') {
            $productID = intval($row->meta_value);
        }
    }

    return $productID;
}

function initiate_order($order_status, $order_id)
{
    $user_id = get_post_meta($order_id, '_customer_user', true);
    if(!$user_id){
        return $order_status;
    }

    $customer_orders = new WP_Query(array(
        'numberposts' => -1, 'meta_key' => '_customer_user', 'meta_value' => $user_id, 'post_type' => 'shop_order', 'post_status' => array(
            'any'
        )
    ));

    if(empty($customer_orders)){ return $order_status; }

    $order = new WC_Order($order_id);
    $orderItems = $order->get_items();
    unset($order);

    if(empty($orderItems)){
        return $order_status;
    }

    foreach($orderItems as $key => $lineItem) {
        $productID = checkFreeSampleGetProductId($key);
        if ($productID > 0) {
            foreach($customer_orders as $corder) {
                $corder = new WC_Order($corder->ID);
                $corderItems = $corder->get_items();
                unset($corder);

                if(empty($corderItems)){
                    continue;
                }

                foreach($corderItems as $ckey => $clineItem) {
                    if($ckey == $key) {
                        continue;
                    }

                    $cproductID = checkFreeSampleGetProductId($ckey);
                    if(false === $cproductID) {
                        continue;
                    }

                    wc_delete_order_item($key);
                    return $order_status;
                }
            }
        }
    }

    return $order_status;
}

add_filter('woocommerce_payment_complete_order_status', 'initiate_order', 10, 2);