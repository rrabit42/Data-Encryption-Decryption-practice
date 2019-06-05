<?php
	
	session_start();
	if(isset($_SESSION['user_name'])){
		$name=$_SESSION['user_name'];
	}
	if(isset($_SESSION['user_type'])){
		$type=strtolower($_SESSION['user_type']);
	}

?>