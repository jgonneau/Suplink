<?php
		//L'on d�marre la session pour ensuite la d�truire, ensuite on redirige sur la page "login.php".
		session_start();
		session_destroy();
		header("Location: login.php");	
		exit;
?>