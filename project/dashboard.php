<?php
	
	//Demarrage de session.
		session_start();
	
	//Si un session existe alors l'on execute le code défini, sinon nous le redirigeons sur la page "login.php".
	if(isset($_SESSION['email']))
	{
		//L'on affiche la session utilisateur
		echo 'Connected as : '.$_SESSION['email'];

		//L'on vérifie si des valeurs sont à récupérer.
		if(isset($_POST['url']) && isset($_POST['shortlink_name']))
		{
			if($_POST['url'] != "" && $_POST['shortlink_name'] != "")
			{
			//Connexion à la base de données.
			$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
		
			//Generation de valeur aleatoire pour le short-link.
			$chaine = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			$lien_genere = 'suplink.com/';
			
			$i=0;
			while($i<5)
			{
				$aleat = rand(0, strlen($chaine));
				$lien_genere .= $chaine[$aleat];
				$i++;
			}
			
			//L'on insère le nouveau lien dans la base de données.
			$bdd->exec('INSERT INTO liens_utilisateurs (name, original_url, shortened_url, shortlinks_user) VALUES (\''.$_POST['shortlink_name'].'\',\''.$_POST['url'].'\',\''.$lien_genere.'\',\''.$_SESSION['email'].'\' )');
			}
		}
	}
	else
	{
		//Redirection
		header("Location: login.php");
		exit;
	}


?>

<!DOCTYPE html>
<html>

	<head>
		<title>SupLink - Dashboard</title>
		   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="authors" content="145920_Gonneau_JeanPaul_SupLinkProject" />
		<meta name="description" content="Make a Short Link"/>
		<LINK REL="SHORTCUT ICON" href="">
		<link rel="stylesheet" type="text/css" href="suplink.css"/>
	</head>
	
	<body>
	
		<div id="entete">
			<ul>
				<li><a href="logout.php">Logout</a> |</li>
				<li><a href="about.php">About</a></li>
			</ul>
		</div>

		<h1>SupLink - Another Url Shortener</h1>
		<br/>

			<!-- Formulaire de création de short-link -->
		<form action="#" method="POST">
		<fieldset>
		<legend>Dashboard</legend>
			<label for="shortlink_name">Name:</label>
			<input class="espacement" type="text" name="shortlink_name"/>
			
			<label for="url">Url:</label>
			<input class="espacement" type="text" name="url"/>
			
			<input class="espacement" type="submit" value="Generate"/>
		</fieldset>
		</form>

		<table border="1">
		<tr>
			<th>Name</th>
			<th>Original URL</th>
			<th>Shortened URL</th>
			<th>Clicks</th>
			<th>Date created</th>
		</tr>
		
		<?php
		
			//Connection à la base de données pour afficher les short-links appartenant à l'utilisateur.
			$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
			$requete = $bdd->query('SELECT * FROM liens_utilisateurs WHERE shortlinks_user = \''.$_SESSION['email'].'\'');
			
			while($resultat = $requete->fetch())
			{
				//L'on insère les données reçus dans la table html.
				echo '<tr><br/>';
				echo '<td>'.$resultat['name'].'</td>';
				echo '<td>'.$resultat['original_url'].'</td>';
				echo '<td><a href="increment.php?shortened_url='.$resultat['shortened_url'].'&original_url='.$resultat['original_url'].'">'.$resultat['shortened_url'].'</a></td>';
				echo '<td>'.$resultat['clicks'].'</td>';
				echo '<td>'.$resultat['date_created'].'</td>';
				echo '</tr>';
			}

			$requete->closeCursor();

		?>
		</table>

		<footer><hr><p>@2013 SupLink - A project developped by <a href="http://www.j-p.work">Gonneau Jean Paul</a></p></footer>

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="suplink.js" ></script>
		
	</body>

</html>
