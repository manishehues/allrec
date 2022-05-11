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
            "SELECT COUNT(po.ID) AS totalcount FROM $wp_post po JOIN $custom_lottery cl ON po.ID WHERE po.ID = cl.post_id"
        );

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'ID';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';
        $where_search = "";
        if (isset($_REQUEST['s']) && $_REQUEST['s'] != '') {

            $where_search = " and po.post_title LIKE '%" . $_REQUEST['s'] . "%' ";
        }


        $this->items = $wpdb->get_results($wpdb->prepare("SELECT po.ID, po.post_title,cl.is_winner_declare ,COUNT(cl.post_id) AS numberOfParticipant,pm.meta_value as totalParticipant
            FROM $wp_post po
            JOIN $custom_lottery cl
            ON po.ID = cl.post_id
            JOIN $wp_post_meta pm
            ON cl.post_id = pm.post_id
            WHERE meta_key = 'total_participants'" . $where_search . "
            GROUP BY po.ID
            limit $per_page OFFSET 0
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
        //print_r($item);

        switch ($column_name) {

            case 'is_winner_declare':
                if ($item['is_winner_declare'] == 1) {
                    return 'declared';
                } else {
                    return '-';
                }
                break;
            case 'winner':
                echo $this->get_declare_winner($item['ID']);
                break;
            case 'action':
                echo '<a href="' . admin_url('admin.php?page=Post-details-page&Post_details_id=' . $item['ID']) . '">View Detail</a>';
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
            'is_winner_declare'    => 'Winner Declared',
            'winner'               => 'Winner Is',
            'action'               => 'Action'
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

    function get_declare_winner($post_id)
    {
        global $wpdb;

        $custom_lottery = $wpdb->prefix . 'custom_lottery_participants';
        $wp_users = $wpdb->prefix . 'users';
        $wp_posts = $wpdb->prefix . 'posts';


        $this->items = $wpdb->get_row("SELECT cl.*,wu.user_login FROM wp_custom_lottery_participants cl 
            JOIN wp_users wu ON cl.id = wu.ID 
            JOIN wp_posts po ON cl.post_id = po.ID 
                WHERE cl.post_id = $post_id and cl.winner = 1 ;
        ");

        return $this->items->user_login;
    }

    /* function process_bulk_action()
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
    } */
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
