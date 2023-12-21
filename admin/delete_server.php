<?php
if($_SERVER['REQUEST_METHOD'] !== "POST"){
	die("Invalid Request");
}
include("includes/connection.php");
$server_id = $_POST['server_id'];
mysqli_query($mysqli, "DELETE FROM servers WHERE server_id=$server_id") or die(mysqli_error($mysqli));
if(mysqli_affected_rows($mysqli) > 0){
	echo "Server Deleted Successfully!";
} else {
	echo "Unable to delete server!";
}

?>