<?php
		//L'on démarre la session pour ensuite la détruire, ensuite on redirige sur la page "login.php".
		session_start();
		session_destroy();
		header("Location: login.php");	
		exit;
?>