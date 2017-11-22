<?php
	
	//Connection à la base de données pour faire incrémenter le nombre de clicks du lien.

	$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
	$requete = $bdd->query('SELECT clicks FROM liens_utilisateurs WHERE shortened_url = \''.$_GET['shortened_url'].'\'');
	$resultat = $requete->fetch();
	
	if($resultat != null)
	{
		//Si le short-link existe on l'incremente dans la base de données.
		$increment_clicks =  $resultat['clicks'] + 1;

		$bdd->exec('UPDATE liens_utilisateurs SET clicks = '.$increment_clicks.' WHERE shortened_url = \''.$_GET['shortened_url'].'\'');
		header('location: '.$_GET['original_url']);
	}

?>
