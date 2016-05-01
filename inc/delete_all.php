<?php 

include 'connexion.php';

// Insert text into messages table
$sql = "TRUNCATE TABLE messages";
$result = $con->query($sql);
$con->close();

// Delete all image from img folder
$files = glob('../img/*');
foreach($files as $file){
  if(is_file($file))
    unlink($file);
}

?>