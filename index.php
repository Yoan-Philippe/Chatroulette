<!DOCTYPE html>
<html>
<head>
	<title>Chatroulette</title>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/jquery-cookie.js"></script>
</head>
<body>

<?php

$con = mysqli_connect("localhost","root","","module_chat");
//$con = mysqli_connect("wknd.o2web.biz","wknd_site","NJi5hEPhC30M","wknd_module_chat");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT * FROM messages ORDER BY created_at ASC";
$result = $con->query($sql); 

date_default_timezone_set('America/Montreal');
$dateTime = new DateTime();
$dateFormated = $dateTime->format('d F');

?>

<div class="container">
	<h1>Chatroulette</h1>
	<button class="reset">Reset</button>
	<div class="chat-box">
		<p class="today"><?= $dateFormated; ?></p>
		<?php 
		if ($result->num_rows > 0) {
			 echo '<ul class="list-message">';
		    while($row = $result->fetch_assoc()) {
		    	$time = substr($row['created_at'], 11,5);
		    	if (strpos(utf8_encode($row['message']), '.jpg') !== false) {
		    	    //$message = '<img width="150" src="/app/webroot/chat/img/' . $row['message'] . '" />';
		    	    $message = '<img width="150" src="/img/' . $row['message'] . '" />';
		    	}
		    	else{
		    		$message = $row['message'];
		    	}
		        echo "<li class='message'><span class='date'>" . $time . "</span> - " . $row['name']. ": " . $message . "<span class='delete' id='message-" . $row["id"] . "'> x</span></li>";
		    }
		    echo '<ul>';
		} ?>
	</div>

	<div class="input-box">
		<input placeholder="Enter a message..." type="text" class="text" />
		<button class="submit-message">Send</button>
	</div>

	<input type="file" id="file" />

</div>

<?php $con->close(); ?>
</body>
</html>