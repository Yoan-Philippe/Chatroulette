<?php

	$name = $_POST['name'];
    //$rootDir = '/home/wknd/public_html/app/webroot/chat/img/';
	$rootDir = 'C:/Users/Yoan/Sites/chat/img/';
    if ( 0 < $_FILES['image']['error'] ) {
        echo 'Error: ' . $_FILES['image']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['image']['tmp_name'], $rootDir . $_FILES['image']['name']);
    }

    include 'connexion.php';

    date_default_timezone_set('America/Montreal');
    $dateTime = new DateTime();
    $dateFormated = $dateTime->format('Y-m-d H:i:s');

    // Insert text into messages table
    $sql = 'INSERT INTO messages (message,name,created_at) VALUES("' . $_FILES['image']['name'] . '","' . $name . '","' . $dateFormated . '")';
    $result = $con->query($sql);
    $con->close();

?>