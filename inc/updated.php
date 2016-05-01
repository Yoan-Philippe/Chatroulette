<?php

include 'connexion.php';

// Get all messages
$sql = "SELECT * FROM messages ORDER BY created_at ASC";
$result = $con->query($sql);

date_default_timezone_set('America/Montreal');
$dateTime = new DateTime();
$dateFormated = $dateTime->format('d F'); ?>


<p class="today"><?= $dateFormated; ?></p>

<?php if ($result->num_rows > 0) {
	 echo '<ul class="list-message">';
    while($row = $result->fetch_assoc()) {
    	$time = substr($row['created_at'], 11,5);
    	if (strpos(utf8_encode($row['message']), '.jpg') !== false) {
            //$message = '<img width="150" src="/app/webroot/chat/img/' . utf8_encode($row['message']) . '" />';
    	    $message = '<img width="150" src="/img/' . utf8_encode($row['message']) . '" />';
    	}
    	else{
    		$message = utf8_encode($row['message']);
    	}
        echo "<li class='message'><span class='date'>" . $time . "</span> - " . $row['name']. ": " . $message . "<span class='delete' id='message-" . $row["id"] . "'> x</span></li>";
    }
    echo '<ul>';
}

$con->close(); ?>

