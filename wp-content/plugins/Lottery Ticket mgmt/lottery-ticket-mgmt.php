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
