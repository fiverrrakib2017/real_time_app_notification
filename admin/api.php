<?php

$action = $_GET['action'];


if(function_exists($action)){
	include('includes/dbconfig.php');
	$action();	
} else {
	echo "function not found";
}

function get_servers() {
	$response['status'] = 1;
	$response['message'] = "Success";
	global $con;
	$results = mysqli_query($con, "SELECT * FROM servers WHERE ServerStatus=1") or die(mysqli_error($con));
	$servers = array();
	if(!$results){
		$response['status'] = 0;
		$response['message'] = mysqli_error($con);
	} else {
		while($row = mysqli_fetch_assoc($results)){
			$servers[] = $row;
		}
		$response['servers'] = $servers;
	}	
	echo json_encode($response);
}
function get_ad_ids() {

	global $con;
	$results = mysqli_query($con, "SELECT * FROM admob") or die(mysqli_error($con));
	$servers = array();
	if(!$results){
		$response['status'] = 0;
		$response['message'] = mysqli_error($con);
	} else {
		while($row = mysqli_fetch_assoc($results)){
			$servers = $row;
		}
	
	}	
	echo json_encode($servers);
}

function get_settings() {

	global $con;
	$results = mysqli_query($con, "SELECT * FROM setting") or die(mysqli_error($con));
	$servers = array();
	if(!$results){
		$response['status'] = 0;
		$response['message'] = mysqli_error($con);
	} else {
		while($row = mysqli_fetch_assoc($results)){
			$servers = $row;
		}
	
	}	
	echo json_encode($servers);

}


?>