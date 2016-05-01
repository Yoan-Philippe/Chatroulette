<?php 

include 'connexion.php';

$messageId = $_POST['id'];

// Delete image from img folder if message is an image
$message = $con->query('SELECT message FROM messages WHERE id=' . $messageId)->fetch_object()->message; 
if (strpos($message, '.jpg') !== false) {
	//$rootDir = '/home/wknd/public_html/app/webroot/chat/img/';
	$rootDir = "C:/Users/Yoan/Sites/chat/img/";
	if(file_exists($rootDir . $message)){
		unlink($rootDir . $message);
	}
}

// Delete message into messages table
$sql = 'DELETE FROM messages WHERE id=' . $messageId;
$result = $con->query($sql);
echo $rootDir . $message;
$con->close(); ?>