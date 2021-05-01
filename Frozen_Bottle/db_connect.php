<?php 
	// connect to the database
	$conn = mysqli_connect('localhost', 'Torvus', 'Aji1407', 'frozen_bottle');
	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}
?>