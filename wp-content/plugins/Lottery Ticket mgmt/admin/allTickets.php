<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class allTickets extends WP_List_Table
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
                if ($item['is_used'] == 1) {
                    return 'Used';
                } else {
                    return 'Unused';
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

function showAllTickets()
{
    global $wpdb;
    $table = new allTickets();
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
};

showAllTickets();
