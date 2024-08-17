<?php
// PHP example of a simple bot that spits a user's message back.

// Include functions
function send_response($update) {
  // Keep track of which iteration of the loop you're in for $update->post_fields
  $i = 0;
  // Now go through the array and send each $method and $post_fields
  foreach ($update->method as $method) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.telegram.org/bot" . BOT_TOKEN . "/$method",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($update->post_fields[$i]),
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded"
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $i++;
  }
  function echo_input($update) {
  // Using the Telegram Bot API method "sendMessage",
  // https://core.telegram.org/bots/api#sendmessage
  $update->method[0] = 'sendMessage';

  // It's going back to the same chat where it came from
  $update->post_fields[0]->chat_id = $update->message->chat->id;

  // The text being returned is just the whole object
  $update->post_fields[0]->text = print_r($update, TRUE);
}
define('BOT_TOKEN', '7446666131:AAEfIn3hZ6B-s_JfADl6TK_3iyuAlPQzgSc');
// Grab the JSON input stream from Telegram, convert it to an object
$update = json_decode(file_get_contents('php://input'));

// Initialize two variables used to respond to Telegram.
// (Arrays allow for multiple responses to be sent to Telegram.)
$update->method = array();
$update->post_fields = array();
// There will always be at least one response
$update->post_fields[0] = new \stdClass();

// Do the thing
echo_input($update);

// Send it all to Telegram's servers using HTTP POST
send_response($update);
