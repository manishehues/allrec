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

//echo dirname(__FILE__);

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


add_filter('page_template', 'wpa3396_page_template');
function wpa3396_page_template($page_template)
{
  if (is_page('my-custom-page-slug')) {
    $page_template = CRUD_PLUGIN_PATH . '/templates/custom-page-template.php';
  }
  return $page_template;
}



add_filter('theme_page_templates', 'pluginname_template_as_option', 10, 3);
function pluginname_template_as_option($page_templates, $theme, $post)
{

  $page_templates['Untitled-1.php'] = 'PageWithoutSidebar';

  return $page_templates;
}

//When our custom template has been chosen then display it for the page
/* add_filter('template_include', 'pluginname_load_template', 99);
function pluginname_load_template($template)
{

  global $post;
  $custom_template_slug   = 'Untitled-1.php';
  $page_template_slug     = get_page_template_slug($post->ID);

  if ($page_template_slug == $custom_template_slug) {
    return CRUD_PLUGIN_PATH . '/templates/' . $custom_template_slug;
  }

  return $template;
} */

//echo plugin_dir_path(__FILE__);



/* =================== frontEnd user dashboard ======================= */

/*
 * Step 1. Add Link (Tab) to My Account menu
 */
add_filter('woocommerce_account_menu_items', 'lottery_ticket_link', 40);
function lottery_ticket_link($menu_links)
{

  $menu_links = array_slice($menu_links, 0, 5, true)
    + array('user-tickets' => 'Ticket')
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


/* ====================== Mail ========================== */

/* function  wpsd_email_to_admin($amount, $Email, $payMethod)
{

  $Email           = sanitize_email($_REQUEST['payemail']);
  $payMethod       = sanitize_text_field($_REQUEST['paymethod']);
  $amount       = filter_var($_REQUEST['payamount'], FILTER_SANITIZE_STRING);

  $headers = array('Content-Type: text/html; charset=UTF-8');
  $to = 'vikasehues@gmail.com';
  $wpsdEmailSubject = __('Request to Transfer Payment!');
  $wpsdEmailMessage = __('Email: ') . $Email;
  $wpsdEmailMessage .= '<br>' . __('Payment method: ') . $payMethod;
  $wpsdEmailMessage .= '<br>' . __('Amount: ') . $amount;

  return wp_mail($to, $wpsdEmailSubject, $wpsdEmailMessage, $headers);
} */