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

    $response = array('message' => 'Winner Declare Successfully', 'rescode' => 200);
  } else {
    $response = array('message' => 'Winner Declare Already', 'rescode' => 404);
  }

  echo json_encode($response);
  exit();
  wp_die();
}
