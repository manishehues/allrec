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
register_deactivation_hook(__FILE__, 'deactivate_ticket_lottery_plugin_function');

function activate_ticket_lottery_plugin_function()
{
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = $wpdb->prefix . 'custom_lottery_ticket';

  $sql = " CREATE TABLE $table_name (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `order_id` int(11) NOT NULL,
    `ticket_number` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `is_used` tinyint(4) NOT NULL,
    PRIMARY KEY (`lot_id`)
  ) $charset_collate; ";

  $table_participant = $wpdb->prefix . 'custom_lottery_participants';
  $participant_sql = "CREATE TABLE $table_participant (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `ticket_number` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) $charset_collate; ";


  $table_comment_count = $wpdb->prefix . 'custom_comment_count';
  $comment_count_sql = "CREATE TABLE $table_comment_count (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `comment_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
  ) $charset_collate;";


  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
  dbDelta($participant_sql);
  dbDelta($comment_count_sql);
}

/* function deactivate_ticket_lottery_plugin_function()
{
  global $wpdb;
  $table_name = $wpdb->prefix .'custom_lottery_ticket';
  $sql = "DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
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
    'LTS mgmt',
    'LTS',
    'manage_options',
    'new-entry',
    'my_menu_output'
  );

  add_submenu_page(
    'new-entry',
    'LTS Application',
    'New Entry',
    'manage_options',
    'new-entry',
    'my_menu_output'
  );
  add_submenu_page(
    'new-entry',
    'LTS Application',
    'View Entries',
    'manage_options',
    'view-entries',
    'my_submenu_output'
  );
  add_submenu_page(
    'new-entry',
    'Participant',
    'Participant',
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

function my_menu_output()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/new_entry.php');
}

function participant()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/participant.php');
}

function PostDetailPage()
{
  require_once(CRUD_PLUGIN_PATH . '/admin/PostDetailPage.php');
}


/* =========================== pick lottery winner  ================================ */
