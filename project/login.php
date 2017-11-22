<?php
	
	//Demarrage de session.
	session_start();

	//Si une session est en cours, on la redirige sur le dashboard.
	if(isset($_SESSION['email']))
	{
		header("Location: dashboard.php");	
		exit;
	}

	//L'on affiche un message sur le coin haut de l'écran si un e-mail d'activation vient d'être envoyé.
	if(isset($_GET['enregistrement']))
	{
		if($_GET['enregistrement'] == 'ok')
		{
			echo "An activation code just be send to your mailbox.";
		}
	}

	//L'on affiche un message sur le coin haut de l'écran si une session d'utilisateur vient d'être activé.
	if(isset($_GET['validation']))
	{
		if($_GET['validation'] == 'ok')
		{
			echo "Your account is now activated.";
		}
	}
	
	//Si des valeurs sont reçus, l'on essaye d'ouvrir une session pour l'utilisateur.
	if(isset($_POST['username']) && isset($_POST['password']))
	{

		try
		{
			//Connextion à la base de données.
			$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
		
			$requete = $bdd->query('SELECT * FROM enregistrement_utilisateurs WHERE email = \''.$_POST['username'].'\'');
			$resultat = $requete->fetch();
			$requete->closeCursor();		

			//L'on vérifie si l'utilisateur possède un compte.
			if($resultat['email'] == $_POST['username'])
			{
				//L'on vérifie si l'utilisateur du compte est activé.
				if($resultat['n_activation'] == 0)
				{
					//L'on vérifie si le password correspond.
					if(crypt($_POST['password'], $resultat['password']) == $resultat['password'])
					{
						$_SESSION['email'] = $resultat['email'];
						header("dashboard.php");	
						exit;
					}
					else
					{ echo "Password incorrect !";}	
				}
				else
				{echo "This user is not active yet";}
			}
			else
			{
				echo "This user isn't registered !";
			}
		}
		catch (Exception $e) //L'on affiche si exeption levée.
		{
			die('Erreur : '.$e->getMessage());
		}
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SupLink - Login</title>
		   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="authors" content="145920_Gonneau_JeanPaul_SupLinkProject" />
		<meta name="description" content="Make a Short Link"/>
		<LINK REL="SHORTCUT ICON" href="">
		<link rel="stylesheet" type="text/css" href="suplink.css"/>
	</head>
	
	<body>
	
		<div id="entete">
			<ul>
				<li><a href="login.php">Login</a> |</li>
				<li><a href="register.php">Register</a> |</li>
				<li><a href="about.php">About</a></li>
			</ul>
		</div>

		<h1>SupLink - Another Url Shortener</h1>
		<br/><br/><br/>

		<form action="" method="POST">
		<fieldset>
		<legend>Login</legend>
			
			<br/>
			<label for="username">Username:</label>
			<input type="text" name="username"/>
			<br/><br/><br/><br/>
			
			<label for="password">Password:</label>
			<input type="password" name="password"/>
			<br/><br/><br/>
			
			<input type="submit" value="Submit"/>
			
		</fieldset>
		</form>

		<footer><hr><p>@2013 SupLink - A project developped by <a href="http://www.supinfo.com">SUPINFO International University</a></p></footer>

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="suplink.js" ></script>
		
	</body>
	
</html>
