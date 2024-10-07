<?php
header('Content-Type: application/json; charset=utf-8');

// Baca body request dari Webhook
$json = file_get_contents('reply.json');
$data = json_decode($json, true);

// Ambil data dari JSON yang diterima
$device = isset($data['device']) ? $data['device'] : null;
$sender = isset($data['sender']) ? $data['sender'] : null;
$message = isset($data['message']) ? $data['message'] : null;
$text = isset($data['text']) ? $data['text'] : null; // button text
$member = isset($data['member']) ? $data['member'] : null;
$name = isset($data['name']) ? $data['name'] : null;
$location = isset($data['location']) ? $data['location'] : null;
$pollname = isset($data['pollname']) ? $data['pollname'] : null;
$choices = isset($data['choices']) ? $data['choices'] : [];
$url = isset($data['url']) ? $data['url'] : null;
$filename = isset($data['filename']) ? $data['filename'] : null;
$extension = isset($data['extension']) ? $data['extension'] : null;

// Fungsi untuk mengirim pesan melalui Fonnte API
function sendFonnte($target, $message) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.fonnte.com/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => array(
	    	'target' => $target,
	    	'message' => $message
	    ),
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: L_x4D76h5E1kDMU_2oAi"  // Ganti dengan API Key Fonnte Anda
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

// Logika untuk memproses pesan yang diterima
if ( $message == "test" ) {
	$reply = "working great!";
} elseif ( $message == "image" ) {
	$reply = "Here is an image message.";
} elseif ( $message == "audio" ) {
	$reply = "This is an audio message.";
} elseif ( $message == "video" ) {
	$reply = "Sending a video message.";
} elseif ( $message == "file" ) {
	$reply = "Here is a file.";
} else {
	$reply = "Sorry, I don't understand. Please use one of the following keywords: Test, Audio, Video, Image, File";
}

// Kirim balasan menggunakan Fonnte API
sendFonnte($sender, $reply);

// Kembalikan respon sukses
echo json_encode([
	'status' => 'success',
	'reply' => $reply
]);
