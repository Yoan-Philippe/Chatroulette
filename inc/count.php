<?php

include 'connexion.php';

// Get all messages
$sql = "SELECT COUNT(*) FROM messages";
$result = $con->query($sql);
$row = $result->fetch_row();

echo $row[0];

$con->close(); ?>

