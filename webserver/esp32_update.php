<?php
require_once('config.php');

//Read the database
if (isset($_POST['check_LED_status'])) {
	// $led_id = $_POST['check_LED_status'];	
	// $sql = "SELECT * FROM LED_status WHERE id = '$led_id';";
	// $result   = mysqli_query($conn, $sql);
	// $row  = mysqli_fetch_assoc($result);
	// if($row['status'] == 0){
	// 	echo "LED_is_off";
	// }
	// else{
	// 	echo "LED_is_on";
	// }
	echo "LED_is_on";	
}	

//Update the database
if (isset($_POST['toggle_LED'])) {
	// $led_id = $_POST['toggle_LED'];	
	// $sql = "SELECT * FROM LED_status WHERE id = '$led_id';";
	// $result   = mysqli_query($conn, $sql);
	// $row  = mysqli_fetch_assoc($result);
	// if($row['status'] == 0){
	// 	$update = mysqli_query($conn, "UPDATE LED_status SET status = 1 WHERE id = 1;");
	// 	echo "LED_is_on";
	// }
	// else{
	// 	$update = mysqli_query($conn, "UPDATE LED_status SET status = 0 WHERE id = 1;");
	// 	echo "LED_is_off";
	// }
	echo "LED_is_on";	
}	
?>