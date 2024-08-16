<?php
// Replace YOUR_BOT_TOKEN with your bot's token
$botToken = "7446666131:AAEfIn3hZ6B-s_JfADl6TK_3iyuAlPQzgSc";
$website = "https://api.telegram.org/bot" . $botToken;

// Get the incoming request content
$update = file_get_contents("php://input");
$updateArray = json_decode($update, TRUE);

// Get message information
$message = $updateArray['message'];
$chatId = $message['chat']['id'];
$text = $message['text'];

// Respond to the message
$responseText = "You sent the message: " . $text;
file_get_contents($website . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($responseText));
?>
