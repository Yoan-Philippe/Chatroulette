<?php

include 'connexion.php';

// Get all messages
$sql = "SELECT name FROM messages ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);
$row = $result->fetch_row();

echo $row[0];

$con->close(); ?>

