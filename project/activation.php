<?php

	//L'on récupère le numéro de série de validation envoyée par Email.
	if (isset($_GET['validation']))
	{
		
		$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
		$requete = $bdd->query('SELECT n_activation FROM enregistrement_utilisateurs WHERE n_activation =  \''.$_GET['validation'].'\'');
		$resultat = $requete->fetch();
		$requete->closeCursor();
		
		//Si un code de serie correspond dans la base de données, l'on met la valeur à 0 : ce qui signifie que le compte est maintenant activé.
		if($resultat['n_activation'] == $_GET['validation'])
		{
			$bdd->exec('UPDATE enregistrement_utilisateurs SET n_activation = 0 WHERE n_activation = '.$_GET['validation']);

			//Redirection vers "Login.php".
			header('location: login.php?validation=ok');
			exit;
		}
		
		//Redirection vers "Login.php".
		header('location: login.php');
		exit;
		
	}
	
?>
