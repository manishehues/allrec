<?php
/* ========= new entery ======== */

add_action('wp_ajax_wqnew_entry', 'wqnew_entry_callback_function');
add_action('wp_ajax_nopriv_wqnew_entry', 'wqnew_entry_callback_function');

function wqnew_entry_callback_function()
{
  global $wpdb;
  $wpdb->get_row("SELECT * FROM `wp_crud` WHERE `title` = '" . $_POST['wqtitle'] . "' AND `description` = '" . $_POST['wqdescription'] . "' ORDER BY `id` DESC");

  if ($wpdb->num_rows < 1) {
    $wpdb->insert("wp_crud", array(
      "title" => $_POST['wqtitle'],
      "description" => $_POST['wqdescription'],
      "created_at" => time(),
      "updated_at" => time()
    ));

    $response = array('message' => 'Data Has Inserted Successfully', 'rescode' => 200);
  } else {
    $response = array('message' => 'Data Has Already Exist', 'rescode' => 404);
  }
  echo json_encode($response);
  exit();
  wp_die();
}

/* ========= update entery ======== */

add_action('wp_ajax_wqedit_entry', 'wqedit_entry_callback_function');
add_action('wp_ajax_nopriv_wqedit_entry', 'wqedit_entry_callback_function');

function wqedit_entry_callback_function()
{
  global $wpdb;
  $wpdb->get_row("SELECT * FROM `wp_crud` WHERE `title` = '" . $_POST['wqtitle'] . "' AND `description` = '" . $_POST['wqdescription'] . "' AND `id`!='" . $_POST['wqentryid'] . "' ORDER BY `id` DESC");
  if ($wpdb->num_rows < 1) {
    $wpdb->update("wp_crud", array(
      "title" => $_POST['wqtitle'],
      "description" => $_POST['wqdescription'],
      "updated_at" => time()
    ), array('id' => $_POST['wqentryid']));

    $response = array('message' => 'Data Has Updated Successfully', 'rescode' => 200);
  } else {
    $response = array('message' => 'Data Has Already Exist', 'rescode' => 404);
  }
  echo json_encode($response);
  exit();
  wp_die();
}


add_action('wp_ajax_numberadd', 'submit_ajax_lottery_number'); // participant in lts 
add_action('wp_ajax_nopriv_numberadd', 'submit_ajax_lottery_number'); //participant in lts

function submit_ajax_lottery_number()
{
  global $wpdb;

  $post_id = sanitize_text_field($_REQUEST['post_id']);
  $ticket_number = sanitize_text_field($_REQUEST['ticket_number']);
  $participant = $wpdb->prefix . "custom_lottery_participants";
  $lottery_ticket = $wpdb->prefix . "custom_lottery_ticket";
  $user_id = get_current_user_id();

  $total_tickets = get_all_tickets($ticket_number);


  foreach ($total_tickets as $key => $val) {

    $wpdb->insert($participant, array(
      "post_id" => $post_id,
      "user_id" => $user_id,
      "ticket_number" => $val->total_tickets,
    ));

    $wpdb->query("UPDATE $lottery_ticket SET is_used = 1 WHERE ticket_number = " . $val->total_tickets);
  }

  //$wpdb->query("INSERT INTO $participant (`post_id`, `user_id`, ticket_number) VALUES( $post_id,$user_id,$ticket_number)");

  //wpsd_email_to_admin($post_id, $ticket_number, $user_id);
  //wpsd_email_to_user($post_id, $ticket_number, $user_id);

  exit();
}


/* ========= declared winner ======== */

add_action('wp_ajax_gen_winner', 'gen_winner_function');
add_action('wp_ajax_nopriv_gen_winner', 'gen_winner_function');

function gen_winner_function()
{

  global $wpdb;

  $custom_lottery = $wpdb->prefix . 'custom_lottery_participants';

  $post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : null;

  $res = $wpdb->get_row("SELECT ticket_number AS Random_Number FROM $custom_lottery WHERE post_id = $post_id and is_winner_declare = 0 ORDER BY RAND() LIMIT 1 ;", ARRAY_A);

  $num = $res['Random_Number'];

  if (!empty($res)) {

    $wpdb->update($custom_lottery, array('is_winner_declare' => 1), array('post_id' => $post_id));

    $wpdb->update($custom_lottery, array('winner' => 1), array('ticket_number' => $num));

    send_email_to_admin_after_declare_winner($num);
    send_email_to_user_after_declare_winner($num);

    $response = array('message' => 'Winner Declare Successfully', 'rescode' => 200);
  } else {
    $response = array('message' => 'Winner Declare Already', 'rescode' => 404);
  }

  echo json_encode($response);

  exit();

  wp_die();
}
