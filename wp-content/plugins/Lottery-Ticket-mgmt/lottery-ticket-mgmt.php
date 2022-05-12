<?php
/*
Plugin Name: Ticket Lottery Management System 
Plugin URI: https://www.ehues.com/
Description: Ticket management system
Author: Ehues
Author URI: https://www.ehues.com/
Version: 1.0.0
*/

global $wpdb;
define('CRUD_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CRUD_PLUGIN_PATH', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, 'activate_ticket_lottery_plugin_function');
//register_deactivation_hook(__FILE__, 'deactivate_ticket_lottery_plugin_function');

function activate_ticket_lottery_plugin_function()
{
  global $wpdb;
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  $charset_collate = $wpdb->get_charset_collate();

  $lottery_ticket = $wpdb->prefix . 'custom_lottery_ticket';

  if ($wpdb->get_var("SHOW TABLES LIKE ' $lottery_ticket '") != $lottery_ticket) {

    $sql = "CREATE TABLE $lottery_ticket (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `order_id` int(11) NOT NULL,
            `ticket_number` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `is_used` tinyint(4) NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate; ";

    dbDelta($sql);
  }


  $table_participant = $wpdb->prefix . 'custom_lottery_participants';

  if ($wpdb->get_var("SHOW TABLES LIKE ' $table_participant '") != $table_participant) {

    $participant_sql = "CREATE TABLE $table_participant (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `post_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `ticket_number` varchar(255) NOT NULL,
            `is_winner_declare` tinyint(4) NOT NULL DEFAULT 0,
            `winner` tinyint(4) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`)
        ) $charset_collate; ";

    dbDelta($participant_sql);
  }


  $table_comment_count = $wpdb->prefix . 'custom_comment_count';

  if ($wpdb->get_var("SHOW TABLES LIKE ' $table_comment_count '") != $table_comment_count) {

    $comment_count_sql = "CREATE TABLE $table_comment_count (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `comment_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

    dbDelta($comment_count_sql);
  }
}

/* function deactivate_ticket_lottery_plugin_function()
{
  global $wpdb;
  $lottery_ticket = $wpdb->prefix . 'custom_lottery_ticket';
    $sql1 = "DROP TABLE IF EXISTS $lottery_ticket";
    $wpdb->query($sql1);

    $table_participant = $wpdb->prefix . 'custom_lottery_participants';
    $sql2 = "DROP TABLE IF EXISTS $table_participant";
    $wpdb->query($sql2);

    $table_comment_count = $wpdb->prefix . 'custom_comment_count';
    $sql3 = "DROP TABLE IF EXISTS $table_comment_count";
    $wpdb->query($sql3);

} */

function load_custom_css_js()
{
  wp_register_style('my_custom_css', CRUD_PLUGIN_URL . '/css/style.css', false, '1.0.0');
  wp_enqueue_style('my_custom_css');
  wp_enqueue_script('my_custom_script1', CRUD_PLUGIN_URL . '/js/custom.js');
  wp_enqueue_script('my_custom_script2', CRUD_PLUGIN_URL . '/js/jQuery.min.js');
  wp_localize_script('my_custom_script1', 'ajax_var', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'load_custom_css_js');

require_once(CRUD_PLUGIN_PATH . '/ajax/ajax_action.php');

add_action('admin_menu', 'my_menu_pages');

function my_menu_pages()
{
  add_menu_page(
    'Lottery Ticket',
    'Lottery Ticket',
    'manage_options',
    'view-entries',
    'my_submenu_output',
    'dashicons-tickets-alt',
    66
  );

  /* add_submenu_page(
    'new-entry',
    'LTS Application',
    'New Entry',
    'manage_options',
    'new-entry',
    'my_menu_output'
  ); */

  add_submenu_page(
    'view-entries',
    'Tickets',
    'Tickets',
    'manage_options',
    'view-entries',
    'my_submenu_output'
  );
  add_submenu_page(
    'view-entries',
    'Participants',
    'Participants',
    'manage_options',
    'view-participant',
    'participant'
  );
  add_submenu_page(
    null,
    'Post Detail page',
    'Post Detail page',
    'manage_options',
    'Post-details-page',
    'PostDetailPage'
  );
}

function my_submenu_output()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/allTickets.php');
}

/* function my_menu_output()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/new_entry.php');
} */

function participant()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/participant.php');
}

function PostDetailPage()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/PostDetailPage.php');
}

/*============= custom template start =============*/

add_filter('page_template', 'wpa3396_page_template');
function wpa3396_page_template($page_template)
{
  if (get_page_template_slug() == 'user-lottries.php') {
    $page_template = CRUD_PLUGIN_PATH . '/templates/user-lottries.php';
  }
  return $page_template;
}

add_filter('theme_page_templates', 'pluginname_template_as_option', 10, 3);
function pluginname_template_as_option($page_templates, $theme, $post)
{
  $page_templates['user-lottries.php'] = 'UserLottries';
  return $page_templates;
}

/*============= custom template start =============*/

/* ====================== Mail after ticket number is using  ========================== */

/* mail after send to Admin when user participat in any post */
function  wpsd_email_to_admin($post_id, $ticket_number, $user_id)
{
  $user_info = get_user_by('ID', $user_id);
  $post_title = get_post($post_id, ARRAY_A);
  $title = $post_title['post_title'];

  $headers = array('Content-Type: text/html; charset=UTF-8');
  //$to = 'vikasehues@gmail.com';
  $to = get_option('admin_email');
  $wpsdEmailSubject = __('New Participation');

  $wpsdEmailMessage = '
    <html>
        <head>
            <title>Email Newsletter Template</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body bgcolor="#e3e3e3">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 602px;width: 100%;border:1px solid #d5d5d5" align="center">
                <tr>
                    <td style="background-color: #fde148;padding:15px" align="center" valign="middle">
                        <h2 style="margin:0;font-family: sans-serif;font-size:30px; color:#000000"> Participated in ';
  $wpsdEmailMessage .= $post_title['post_title'];
  $wpsdEmailMessage .= '</h2>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #ffffff;padding:0px 20px" align="center">
                            <h4 style="font-size:25px;font-family: sans-serif;margin:25px 0px 20px;color:#000000 ">Hello Admin </h4>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="middle">
                        <p style="font-size:16px;font-family: sans-serif;color:#000000;margin:20px 0px">
                        A new user <b>';
  $wpsdEmailMessage .= $user_info->user_login;
  $wpsdEmailMessage .= '</b> has been Participat in <b>';
  $wpsdEmailMessage .= $post_title['post_title'];
  $wpsdEmailMessage .= '</b></p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:100px 30px;background-image: url("https://i10.dainikbhaskar.com/thumbnails/730x548/web2images/www.bhaskar.com/2016/11/24/evoke_socks-4_1479993435.jpg");background-size: cover;background-position: center;" align="center" valign="middle">
                        <a href="" style="display: inline-block;background-color: #fde148;text-decoration: none;padding:12px 30px;text-decoration: none;font-family: sans-serif;font-weight: bold;color:#000000;margin:20px 0px;border-radius: 5px">TICKET NO- ';
  $wpsdEmailMessage .= $ticket_number;
  $wpsdEmailMessage .= ' </a>
                    </td>
                </tr>
            </table>
        </body>
    </html>';

  return wp_mail($to, $wpsdEmailSubject, $wpsdEmailMessage, $headers);
}

/* mail after send to user participat in any post */
function wpsd_email_to_user($post_id, $ticket_number, $user_id)
{
  $user_info = get_user_by('ID', $user_id);
  $userMail = $user_info->user_email;

  $post_title = get_post($post_id, ARRAY_A);
  $title = $post_title['post_title'];

  $headers = array('Content-Type: text/html; charset=UTF-8');
  $to = 'vikasehues@gmail.com';
  //$to = $userMail;
  $wpsdEmailSubject = __('New Participation');

  $wpsdEmailMessage = '
    <html>
        <head>
            <title>Email Newsletter Template</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body bgcolor="#e3e3e3">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 602px;width: 100%;border:1px solid #d5d5d5" align="center">
                <tr>
                    <td style="background-color: #fde148;padding:15px" align="center" valign="middle">
                        <h2 style="margin:0;font-family: sans-serif;font-size:30px; color:#000000">Thanks for Participated in ';
  $wpsdEmailMessage .= $post_title['post_title'];
  $wpsdEmailMessage .= '</h2>
                    </td>
                </tr>
               
                <tr>
                    <td align="center" valign="middle">
                        <p style="font-size:16px;font-family: sans-serif;color:#000000;margin:20px 0px">
                        Hey, <b>';
  $wpsdEmailMessage .= $user_info->user_login;
  $wpsdEmailMessage .= '</b> Result of <b>';
  $wpsdEmailMessage .= $post_title['post_title'];
  $wpsdEmailMessage .= '</b> declared shortly. </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:100px 30px;background-image: url("https://i10.dainikbhaskar.com/thumbnails/730x548/web2images/www.bhaskar.com/2016/11/24/evoke_socks-4_1479993435.jpg");background-size: cover;background-position: center;" align="center" valign="middle">
                        <a href="" style="display: inline-block;background-color: #fde148;text-decoration: none;padding:12px 30px;text-decoration: none;font-family: sans-serif;font-weight: bold;color:#000000;margin:20px 0px;border-radius: 5px">TICKET NO- ';
  $wpsdEmailMessage .= $ticket_number;
  $wpsdEmailMessage .= ' </a>
                    </td>
                </tr>
            </table>
        </body>
    </html>';

  return wp_mail($to, $wpsdEmailSubject, $wpsdEmailMessage, $headers);
}

/* mail after winner declaration to admin */
function send_email_to_admin_after_declare_winner($ticket_number)
{
  global $wpdb;
  $table_name = $wpdb->prefix . "custom_lottery_participants";
  $declaredWinner = $wpdb->get_row("SELECT * FROM $table_name WHERE ticket_number = $ticket_number AND winner = 1 ");

  $decWinUserTic = $declaredWinner->ticket_number;
  $decWinUserId = $declaredWinner->user_id;
  $decWinPostId = $declaredWinner->post_id;

  $user_info = get_user_by('ID', $decWinUserId);
  $post_title = get_post($decWinPostId, ARRAY_A);
  $title = $post_title['post_title'];

  $headers = array('Content-Type: text/html; charset=UTF-8');
  $to = 'vikasehues@gmail.com';
  //$to = get_option('admin_email');
  $wpsdEmailSubject = __('Winner Declared');

  $wpsdEmailMessage = '
    <html>
        <body bgcolor="#e3e3e3">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 602px;width: 100%;border:1px solid #d5d5d5" align="center">
                <tr>
                    <td style="background-color: #fde148;padding:15px" align="center" valign="middle">
                        <h2 style="margin:0;font-family: sans-serif;font-size:30px; color:#000000"> Winner of this Event ';
  $wpsdEmailMessage .= $title;
  $wpsdEmailMessage .= '</h2>
                    </td>
                </tr>
               
                <tr>
                    <td align="center" valign="middle">
                        <p style="font-size:16px;font-family: sans-serif;color:#000000;margin:20px 0px">
                        Here is winner , <b>';
  $wpsdEmailMessage .= $user_info->user_login;
  $wpsdEmailMessage .= '</b> of the Event  <b>';
  $wpsdEmailMessage .= $title;
  $wpsdEmailMessage .= '</b>.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:100px 30px;background-image: url("https://i10.dainikbhaskar.com/thumbnails/730x548/web2images/www.bhaskar.com/2016/11/24/evoke_socks-4_1479993435.jpg");background-size: cover;background-position: center;" align="center" valign="middle">
                        <a href="" style="display: inline-block;background-color: #fde148;text-decoration: none;padding:12px 30px;text-decoration: none;font-family: sans-serif;font-weight: bold;color:#000000;margin:20px 0px;border-radius: 5px">TICKET NO- ';
  $wpsdEmailMessage .= $decWinUserTic;
  $wpsdEmailMessage .= ' </a>
                    </td>
                </tr>
            </table>
        </body>
    </html>';

  return wp_mail($to, $wpsdEmailSubject, $wpsdEmailMessage, $headers);
}

/* mail after winner declaration to user */
function send_email_to_user_after_declare_winner($ticket_number)
{
  global $wpdb;
  $table_name = $wpdb->prefix . "custom_lottery_participants";
  $declaredWinner = $wpdb->get_row("SELECT * FROM $table_name WHERE ticket_number = $ticket_number AND winner = 1 ");

  $decWinUserTic = $declaredWinner->ticket_number;
  $decWinUserId = $declaredWinner->user_id;
  $decWinPostId = $declaredWinner->post_id;

  $user_info = get_user_by('ID', $decWinUserId);
  $userMail = $user_info->user_email;
  $post_title = get_post($decWinPostId, ARRAY_A);
  $title = $post_title['post_title'];

  $headers = array('Content-Type: text/html; charset=UTF-8');
  $to = 'vikasehues@gmail.com';
  //$to = $userMail;
  $wpsdEmailSubject = __('Winner Declared');

  $wpsdEmailMessage = '
    <html>
        <body bgcolor="#e3e3e3">
            <table border="0" cellpadding="0" cellspacing="0" style="max-width: 602px;width: 100%;border:1px solid #d5d5d5" align="center">
                <tr>
                    <td style="background-color: #fde148;padding:15px" align="center" valign="middle">
                        <h2 style="margin:0;font-family: sans-serif;font-size:30px; color:#000000"> Winner of this Event ';
  $wpsdEmailMessage .= $title;
  $wpsdEmailMessage .= '</h2>
                    </td>
                </tr>
               
                <tr>
                    <td align="center" valign="middle">
                        <p style="font-size:16px;font-family: sans-serif;color:#000000;margin:20px 0px">
                        Here is winner , <b>';
  $wpsdEmailMessage .= $user_info->user_login;
  $wpsdEmailMessage .= '</b> of the Event  <b>';
  $wpsdEmailMessage .= $title;
  $wpsdEmailMessage .= '</b>.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:100px 30px;background-image: url("https://i10.dainikbhaskar.com/thumbnails/730x548/web2images/www.bhaskar.com/2016/11/24/evoke_socks-4_1479993435.jpg");background-size: cover;background-position: center;" align="center" valign="middle">
                        <a href="" style="display: inline-block;background-color: #fde148;text-decoration: none;padding:12px 30px;text-decoration: none;font-family: sans-serif;font-weight: bold;color:#000000;margin:20px 0px;border-radius: 5px">TICKET NO- ';
  $wpsdEmailMessage .= $decWinUserTic;
  $wpsdEmailMessage .= ' </a>
                    </td>
                </tr>
            </table>
        </body>
    </html>';

  return wp_mail($to, $wpsdEmailSubject, $wpsdEmailMessage, $headers);
}

/* =================== frontEnd user dashboard ======================= */

/*
 * Step 1. Add Link (Tab) to My Account menu
*/
add_filter('woocommerce_account_menu_items', 'lottery_ticket_link', 40);
function lottery_ticket_link($menu_links)
{

  $new = array('user-tickets' => 'Ticket', 'user-lottries' => 'Lottry withdrawal');
  $menu_links = array_slice($menu_links, 0, 5, true)
    + $new
    + array_slice($menu_links, 5, NULL, true);

  return $menu_links;
}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action('init', 'add_endpoint');
function add_endpoint()
{
  // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
  add_rewrite_endpoint('user-tickets', EP_PAGES);
  //add_rewrite_endpoint('link2', EP_PAGES);
}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action('woocommerce_account_user-tickets_endpoint', 'misha_my_account_endpoint_content');
function misha_my_account_endpoint_content()
{

  global $wpdb;
  $user_id = get_current_user_id();

  $limit = 10;
  if (isset($_GET['pg'])) {
    $page = $_GET['pg'];
  } else {
    $page = 1;
  }
  $offset = ($page - 1) * $limit;

  $ticket = $wpdb->prefix . 'custom_lottery_ticket';


  $totalCount = " SELECT * FROM $ticket where `user_id` = $user_id ORDER BY id DESC LIMIT $offset, $limit ";
  $tickets = $wpdb->get_results($totalCount);
  $rowcount = $wpdb->num_rows;

  $sql = " SELECT * FROM $ticket where `user_id` = $user_id ";

  $wpdb->get_results($sql);

  if ($wpdb->num_rows > 0) {
    $total_records = $wpdb->num_rows;
    $total_page = ceil($total_records / $limit);
  }

  require_once(CRUD_PLUGIN_PATH . '/frontend/front-end.php');
}

/*
 * Step 4
*/


function my_custom_endpoint_content()
{
  wc_get_template('myaccount/user-lottries.php');
}

add_action('woocommerce_account_link2_endpoint', 'my_custom_endpoint_content');


/* function example_forum_link($menu_links)
{

  // we will hook "womanide-forum" later
  $new = array('example-forum' => 'Forum Example');

  // or in case you need 2 links
  // $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

  // array_slice() is good when you want to add an element between the other ones
  $menu_links = array_slice($menu_links, 0, 1, true)
    + $new
    + array_slice($menu_links, 1, NULL, true);


  return $menu_links;
}

add_filter('woocommerce_account_menu_items', 'example_forum_link'); */
