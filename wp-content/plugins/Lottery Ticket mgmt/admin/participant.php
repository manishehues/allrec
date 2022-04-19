<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class participantTable extends WP_List_Table
{
    function prepare_items()
    {

        global $wpdb, $current_user;

        $wp_post = $wpdb->prefix . 'posts';
        $custom_lottery = $wpdb->prefix . 'custom_lottery_participants';
        $wp_post_meta = $wpdb->prefix . 'postmeta';
        $per_page = 25;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $total_items = $wpdb->get_var(
            "SELECT COUNT(po.ID) AS totalcount FROM wp_posts po JOIN wp_custom_lottery_participants cl ON po.ID WHERE po.ID = cl.post_id"
        );

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'ID';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
        $where_search = "";
        if (isset($_REQUEST['s']) && $_REQUEST['s'] != '') {


            $where_search = " Where lt.order_id LIKE '%" . $_REQUEST['s'] . "%'
	            OR lt.ticket_number LIKE '%" . $_REQUEST['s'] . "%'
                OR ut.user_login LIKE '%" . $_REQUEST['s'] . "%'
                OR ut.user_email LIKE '%" . $_REQUEST['s'] . "%'";
        }

        /* $this->items = $wpdb->get_results($wpdb->prepare("SELECT lt.*,ut.user_login,ut.user_email 
          FROM 
            wp_custom_lottery_ticket as lt 
              LEFT JOIN wp_users AS ut 
                ON lt.user_id = ut.ID  " . $where_search . "
            ORDER BY lt.id DESC LIMIT " . $per_page . " OFFSET " . $paged * $per_page), ARRAY_A); */

        /* echo "SELECT po.ID, po.post_title, COUNT(cl.post_id) AS numberOfParticipant,pm.meta_value as totalParticipant
            FROM $wp_post po
            JOIN $custom_lottery cl
            ON po.ID = cl.post_id
            JOIN $wp_post_meta pm
            ON cl.post_id = pm.post_id
            WHERE meta_key = 'total_participants'
            GROUP BY po.ID
            limit $per_page OFFSET 0
            ;
        "; */

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT po.ID, po.post_title, COUNT(cl.post_id) AS numberOfParticipant,pm.meta_value as totalParticipant
            FROM $wp_post po
            JOIN $custom_lottery cl
            ON po.ID = cl.post_id
            JOIN $wp_post_meta pm
            ON cl.post_id = pm.post_id
            WHERE meta_key = 'total_participants'
            GROUP BY po.ID
            limit $per_page OFFSET 0
        "), ARRAY_A);

        //print_r($this->items);
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }

    function column_default($item, $column_name)
    {
        //print_r(admin_url());
        //pr($item);

        switch ($column_name) {
            case 'action':
                echo '<a href="' . admin_url('admin.php?page=new-entry&entryid=' . $item['ID']) . '">View Detail</a>';
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
            'cb'                   => '<input type="checkbox" />',
            'ID'                   => 'Post ID',
            'post_title'           => 'Post Title',
            'numberOfParticipant'  => 'Number of Participants',
            'totalParticipant'     => 'Total Participants',
            /* 'order_id'      => 'O',
            'ticket_number' => 'Numbers',
            'is_used'       => 'Status',
            'created_at'    => 'Datetime', */
            'action'        => 'Action'
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
        //$wp_post = $wpdb->prefix . 'custom_lottery_ticket';
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $wp_post WHERE id IN($ids)");
            }
        }
    }
}


function showAllPaticipants()
{
    global $wpdb;
    $table = new participantTable();
    $table->prepare_items();
    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="div_message" id="message"><p>' . sprintf('Items deleted: %d', count($_REQUEST['id'])) . '</p></div>';
    }
    ob_start();
?>
    <div class="wrap wqmain_body">
        <h3>Participant</h3>
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

showAllPaticipants();
