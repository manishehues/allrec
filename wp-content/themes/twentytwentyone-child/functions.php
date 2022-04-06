<?php
/* Child theme generated with WPS Child Theme Generator */

if (!function_exists('b7ectg_theme_enqueue_styles')) {
    add_action('wp_enqueue_scripts', 'b7ectg_theme_enqueue_styles');

    function b7ectg_theme_enqueue_styles()
    {
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
        wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array('parent-style'));
        wp_enqueue_style('slick-style', get_stylesheet_directory_uri() . '/assets/css/slick.css', array('parent-style'));
        wp_enqueue_style('responsive-style', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array('parent-style'));

        wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.js');
        wp_enqueue_script('global-js', get_stylesheet_directory_uri() . '/assets/js/global.js');
    }
}


/*remove breadcrums*/
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
/*remove breadcrums*/
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10);


function pr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die();
}


/* =============== Lottery System Functionality Start ============== */

add_action('woocommerce_new_order', 'genrate_lottery_numbers', 99);
function genrate_lottery_numbers($order_id)
{
    global $wpdb;
    $order = new WC_Order($order_id);
    //print_r($order);
    $tickets = intdiv($order->total, 20);

    $userId = $order->customer_id;
    $orderId = $order_id;
    $table_name = $wpdb->prefix . "custom_lottery_ticket";

    for ($i = 1; $i <= $tickets; $i++) {

        $ticketNumber =  rand(10000, 99999);

        $wpdb->insert($table_name, array(
            "user_id" => $userId,
            "order_id" => $orderId,
            "ticket_number" => $ticketNumber,
        ));
    }

    //die();
    //your code
}


function product_ticket_detail($product)
{

    $tickets = intdiv($product->get_price(), 20);
    $ticket_str = "Ticket";

    if ($tickets > 1) {
        return $ticket_str = "Tickets";
    }
}

/* =============== Lottery System Functionality End ============== */
