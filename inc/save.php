<?php 

$text = utf8_decode($_POST['text']);
$name = $_POST['name'];

include 'connexion.php';

date_default_timezone_set('America/Montreal');
$dateTime = new DateTime();
$dateFormated = $dateTime->format('Y-m-d H:i:s');

// Insert text into messages table
$sql = 'INSERT INTO messages (message,name,created_at) VALUES("' . $text . '","' . $name . '","' . $dateFormated . '")';
$result = $con->query($sql);
$con->close(); ?>