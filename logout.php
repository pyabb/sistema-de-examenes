<?php

	session_start();
	
	$userType = "";

	if(isset($_SESSION['sistemaExamenes']['user'])){

		unset($_SESSION['sistemaExamenes']['user']);

		session_destroy();
		
		header('Location:index.php');
	
	}else{
	
		echo "<div style='font-weight:bold;'>ERROR</div>";
	
	}

?>