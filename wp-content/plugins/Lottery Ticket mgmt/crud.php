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
  add_menu_page('LTS mgmt', 'LTS', 'manage_options', 'new-entry', 'my_menu_output');
  add_submenu_page('new-entry', 'LTS Application', 'New Entry', 'manage_options', 'new-entry', 'my_menu_output');
  add_submenu_page('new-entry', 'LTS Application', 'View Entries', 'manage_options', 'view-entries', 'my_submenu_output');
}

function my_menu_output()
{
  require_once(CRUD_PLUGIN_PATH . '/admin-templates/new_entry.php');
}

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class EntryListTable extends WP_List_Table
{

  function __construct()
  {
    global $status, $page;
    parent::__construct(array(
      'singular' => 'Entry Data',
      'plural' => 'Entry Datas',
    ));
  }

  function column_default($item, $column_name)
  {
    //print_r(admin_url());

    switch ($column_name) {
      case 'user_login':
        return '<a target="_blank" href="' . admin_url('user-edit.php?user_id=' . $item['user_id'] . '&wp_http_referer=%2Fallrec%2Fwp-admin%2Fusers.php') . '">' . $item['user_login'] . '</a>';
      case 'order_id':
        return '<a target="_blank" href="' . admin_url('post.php?post=' . $item['order_id'] . '&action=edit') . '">' . $item['order_id'] . '</a>';
      case 'is_used':
        return 'Unused';
        if (!$item['is_used'] == 0) {
          return 'Used';
        }
      case 'created_at':
        return
          date('F j, Y', strtotime($item['created_at']));;
      case 'action':
        echo '<a href="' . admin_url('admin.php?page=new-entry&entryid=' . $item['id']) . '">Edit</a>';
    }
    return $item[$column_name];
  }

  function column_feedback_name($item)
  {
    $actions = array('delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id']));
    return sprintf('%s %s', $item['id'], $this->row_actions($actions));
  }

  function column_cb($item)
  {
    return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id']);
  }

  function get_columns()
  {
    $columns = array(
      'cb'            => '<input type="checkbox" />',
      'user_login'    => 'Username',
      'user_email'    => 'Email',
      'order_id'      => 'Order ID',
      'ticket_number' => 'Numbers',
      'is_used'       => 'Status',
      'created_at'    => 'Datetime',
      /* 'action'        => 'Action' */
    );
    return $columns;
  }

  function get_sortable_columns()
  {
    $sortable_columns = array(
      'user_login' => array('user_login', true),
      'user_email' => array('user_email', true)
    );
    return $sortable_columns;
  }

  function get_bulk_actions()
  {
    $actions = array('delete' => 'Delete');
    return $actions;
  }

  function process_bulk_action()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_lottery_ticket';
    if ('delete' === $this->current_action()) {
      $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
      if (is_array($ids)) $ids = implode(',', $ids);
      if (!empty($ids)) {
        $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
      }
    }
  }

  function prepare_items()
  {

    //$orderby = isset($_REQUEST['orderby']) ? trim($_REQUEST['orderby']) :

    global $wpdb, $current_user;

    $table_name = $wpdb->prefix . 'custom_lottery_ticket';
    $table_user = $wpdb->prefix . 'users';
    $per_page = 25;
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->process_bulk_action();

    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

    $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

    $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
    $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
    $where_search = "";
    if (isset($_REQUEST['s']) && $_REQUEST['s'] != '') {


      $where_search = " Where lt.order_id LIKE '%" . $_REQUEST['s'] . "%'
	            OR lt.ticket_number LIKE '%" . $_REQUEST['s'] . "%'
              OR ut.user_login LIKE '%" . $_REQUEST['s'] . "%'
              OR ut.user_email LIKE '%" . $_REQUEST['s'] . "%'";
    }

    $this->items = $wpdb->get_results($wpdb->prepare("SELECT lt.*,ut.user_login,ut.user_email 
          FROM 
            wp_custom_lottery_ticket as lt 
              LEFT JOIN wp_users AS ut 
                ON lt.user_id = ut.ID  " . $where_search . "
            ORDER BY lt.id DESC LIMIT " . $per_page . " OFFSET " . $paged * $per_page), ARRAY_A);

    //print_r($this->items);
    $this->set_pagination_args(array(
      'total_items' => $total_items,
      'per_page' => $per_page,
      'total_pages' => ceil($total_items / $per_page)
    ));
  }
}

function my_submenu_output()
{
  global $wpdb;
  $table = new EntryListTable();
  $table->prepare_items();
  $message = '';
  if ('delete' === $table->current_action()) {
    $message = '<div class="div_message" id="message"><p>' . sprintf('Items deleted: %d', count($_REQUEST['id'])) . '</p></div>';
  }
  ob_start();
?>
  <div class="wrap wqmain_body">
    <h3>Tickets</h3>
    <?php echo $message; ?>
    <form id="entry-table" method="GET">
      <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
      <?php $table->search_box('search', 'search_id');
      $table->display() ?>
    </form>
  </div>
<?php
  $wq_msg = ob_get_clean();
  echo $wq_msg;
}
