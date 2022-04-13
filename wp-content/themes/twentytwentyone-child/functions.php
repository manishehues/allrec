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

// Our custom post type function
function create_posttype()
{

    register_post_type(
        'give_away',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('give_away'),
                'singular_name' => __('away')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'give_away'),
            'show_in_rest' => true,

        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');

add_action('pre_get_posts', 'add_my_post_types_to_query');

function add_my_post_types_to_query($query)
{
    if (is_home() && $query->is_main_query())
        $query->set('post_type', array('post', 'give_away'));
    return $query;
}


/* =============== comment system Start ============== */


add_action('wp_enqueue_scripts', 'misha_ajax_comments_scripts');

function misha_ajax_comments_scripts()
{
    // I think jQuery is already included in your theme, check it yourself
    wp_enqueue_script('jquery');

    // just register for now, we will enqueue it below
    wp_register_script('ajax_comment', get_theme_file_uri('/assets/js/ajax-comment.js'), array('jquery'));

    // let's pass ajaxurl here, you can do it directly in JavaScript but sometimes it can cause problems, so better is PHP
    wp_localize_script('ajax_comment', 'misha_ajax_comment_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
    ));

    wp_enqueue_script('ajax_comment');
}


add_action('wp_ajax_ajaxcomments', 'misha_submit_ajax_comment'); // wp_ajax_{action} for registered user
add_action('wp_ajax_nopriv_ajaxcomments', 'misha_submit_ajax_comment'); // wp_ajax_nopriv_{action} for not registered users

function misha_submit_ajax_comment()
{

    $comment = wp_handle_comment_submission(wp_unslash($_POST));

    $comment_parent = "";

    /*
	 * Set Cookies
	 */

    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);

    /*
	 * If you do not like this loop, pass the comment depth from JavaScript code
	 */
    $comment_depth = 1;
    //$comment_parent = $comment->comment_parent;


    $postId = isset($_REQUEST['comment_post_ID']) ? $_REQUEST['comment_post_ID'] : '';

    $comments = get_comments(array('post_id' => $postId, 'order' => 'ASC'));

    $commentList = '';

    if ($comments) {

        foreach ($comments as $key => $comment) {


            $commentList .= '<li class="profile_single" id="comment-' . $comment->comment_ID . '">
                            <div class="user">
                              <img src="' . get_stylesheet_directory_uri() . '/assets/images/user.png" />' .               $comment->comment_author . '
                              <span>' . $comment->comment_content . '</span>
                              <div id="respond"></div>
                              <div class="likes like-comment" rel="' . $comment->comment_ID . '">
                                <span class="time">1h - </span>
                                
                                 <span class="time like-comment" rel="' . $comment->comment_ID . '"> likes <span class="likes">' . $comment->cmnt_like . '</span>
                                </span>   
                                
                                <span class="reply comment-reply-link">Reply</span>
                              </div>
                          </li>';
        }
    }
    echo $commentList;

    die();
}


add_action('wp_ajax_cmntlike', 'submit_ajax_comment_like'); //
add_action('wp_ajax_nopriv_cmntlike', 'submit_ajax_comment_like'); //


function submit_ajax_comment_like()
{
    global $wpdb;

    //print_r($_REQUEST);

    $table_name = $wpdb->prefix . "comments";
    $commmentTable = $wpdb->prefix . "custom_comment_count";

    $id = stripslashes_deep($_REQUEST['comment_id']);
    $user_id = get_current_user_id();

    $wpdb->get_results("SELECT id FROM $commmentTable WHERE `comment_id` = " . $id . " AND `user_id` = " . $user_id);

    if ($wpdb->num_rows == 0) {

        $wpdb->query("INSERT INTO $commmentTable (`user_id`, comment_id) VALUES($user_id,$id)");

        $wpdb->query("UPDATE $table_name SET cmnt_like = cmnt_like + 1 WHERE comment_ID = " . $id);
    }

    die();
}

function get_all_tickets_of_current_user()
{

    global $wpdb;

    $table_name = $wpdb->prefix . "custom_lottery_ticket";
    $user_id = get_current_user_id();
    $res =  $wpdb->get_var("SELECT COUNT(*) as total FROM $table_name WHERE `user_id` = " . $user_id);

    return $res;
}

function get_all_tickets()
{

    global $wpdb;

    $table_name = $wpdb->prefix . "custom_lottery_ticket";
    $user_id = get_current_user_id();

    //echo "SELECT ticket_number as total_tickets FROM $table_name WHERE `user_id` = " . $user_id;

    $res =  $wpdb->get_results("SELECT id, ticket_number as total_tickets FROM $table_name WHERE `user_id` = " . $user_id);

    //pr($res);

    return $res;
}



/* function comment_exist($id)
{
    global $wpdb;

    $user_id = get_current_user_id();

    $commmentTable = $wpdb->prefix . "custom_comment_count";

    echo "SELECT id FROM $commmentTable WHERE `comment_id` = " . $id . " AND `user_id` = " . $user_id;

    $res = $wpdb->get_results("SELECT id FROM $commmentTable WHERE `comment_id` = " . $id . " AND `user_id` = " . $user_id);

    return $res;

} */


/* =============== comment system End ============== */