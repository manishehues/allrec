<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class showPostDetail extends WP_List_Table
{
    function prepare_items()
    {

        global $wpdb, $current_user;

        $custom_lottery = $wpdb->prefix . 'custom_lottery_participants';
        $wp_users = $wpdb->prefix . 'users';
        $wp_posts = $wpdb->prefix . 'posts';


        $detail_post_id = isset($_GET['Post_details_id']) ? $_GET['Post_details_id'] : null;

        $per_page = 25;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $total_items = $wpdb->get_var(
            "SELECT COUNT(po.id) AS totalcount FROM $wp_users po JOIN $custom_lottery cl ON po.ID WHERE po.ID = cl.post_id"
        );

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
        $where_search = "";
        if (isset($_REQUEST['s']) && $_REQUEST['s'] != '') {

            $where_search = " and po.post_title LIKE '%" . $_REQUEST['s'] . "%'
                OR wu.user_login LIKE '%" . $_REQUEST['s'] . "%'
                OR wu.user_email LIKE '%" . $_REQUEST['s'] . "%'
            ";
        }

        $this->items = $wpdb->get_results($wpdb->prepare(" SELECT cl.*,wu.user_login,wu.user_email,po.post_title FROM $custom_lottery cl 
            JOIN $wp_users wu ON cl.user_id = wu.ID 
            JOIN $wp_posts po ON cl.post_id = po.ID 
                WHERE cl.post_id = $detail_post_id " . $where_search . " limit $per_page OFFSET 0
        "), ARRAY_A);

        //pr($this->items);

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }

    function column_default($item, $column_name)
    {

        switch ($column_name) {

            case 'user_login':
                return '<a target="_blank" href="' . admin_url('user-edit.php?user_id=' . $item['user_id'] . '&wp_http_referer=%2Fallrec%2Fwp-admin%2Fusers.php') . '">' . $item['user_login'] . '</a>';


            case 'post_title':
                return '<a target="_blank" href="' . admin_url('post.php?post=' . $item['post_id'] . '&action=edit') . '">' . $item['post_title'] . '</a>';

            case 'user_email':
                return '<a href="mailto:' . $item['user_email'] . '">' . $item['user_email'] . '</a>';

            case 'winner':
                if ($item['winner'] == 1) {
                    return 'winner';
                } else {
                    return '-';
                }

            case 'action':
                echo '<a href="' . admin_url('admin.php?page=new-entry&entryid=' . $item['id']) . '">View Detail</a>';
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
            'post_title'           => 'Post Title',
            'user_login'           => 'Username',
            'user_email'           => 'Email',
            'winner'               => 'Winner',
            'ticket_number'        => 'Ticket Number',
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

    /* function process_bulk_action()
    {
        global $wpdb;
        //$wp_users = $wpdb->prefix . 'custom_lottery_ticket';
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $wp_users WHERE id IN($ids)");
            }
        }
    } */
}


function showPostDetailfn()
{
    global $wpdb;
    $table = new showPostDetail();
    $table->prepare_items();
    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="div_message" id="message"><p>' . sprintf('Items deleted: %d', count($_REQUEST['id'])) . '</p></div>';
    }
    ob_start();
?>
    <div class="wrap wqmain_body">
        <h3>Post Detail</h3>
        <form id="gen_winner" method="POST">
            <input type="hidden" id="gen_post_id" name="gen_post_id" value="<?php echo $_GET['Post_details_id'] ?>" />
            <input type="submit" name="submit" id="winner" class="button button-primary" value="Genrate winner">
        </form>

        <?php echo $message; ?>
        <form id="entry-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $table->search_box('search', 'search_id');
            $table->display() ?>
        </form>

        <div class="wqsubmit_message"></div>
    </div>
<?php
    $wq_msg = ob_get_clean();
    echo $wq_msg;
};

showPostDetailfn();
