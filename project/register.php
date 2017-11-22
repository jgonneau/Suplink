<?php
	
	//Demarrage de session.
	session_start();
	
	//Si une session est en cours, on la redirige sur le dashboard.
	if(isset($_SESSION['email']))
	{
		header("Location: dashboard.php");	
		exit;
	}

	//Si des valeurs sont reçus alors l'on se connecte à la base pour tenter d'enregistrer l'utilisateur.
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmation']))
	{
		
		//Connection base de donnée :
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=projectsuplink', '', '');
	
			//L'on va rechercher si l'utilisateur est déjà enregistré ou non.
			$postemail = $_POST['email'];
			$requete = $bdd->query('SELECT * FROM enregistrement_utilisateurs WHERE email=\''.$postemail.'\'');
			$resultat = $requete->fetch();
			$requete->closeCursor();

			//Si l'utilisateur est déjà inscrit dans la base de données : nous prévenons l'utilisateur, sinon nous l'inscrivons.
			if (isset($resultat['email']))
			{
				echo "This user is already registered !";
			}
			else
			{
				if($_POST['password'] == $_POST['confirmation'])
				{
					$requete2 = $bdd->prepare('INSERT INTO enregistrement_utilisateurs(email, password, n_activation) VALUES (:val_email, :val_password, :val_n_activation) ');
					
					//Génération d'un code d'activation ;
					$validat = rand(10000000, 99999999);

					$contenu = "Bonjour, ".PHP_EOL.PHP_EOL."Voici votre lien d'activation pour valider votre compte : ".PHP_EOL."activation.php?validation=".$validat;

					mail($_POST['email'], 'Confirmation Validation', $contenu); 

					$requete2->execute(array('val_email' => $_POST['email'], 'val_password' => crypt($_POST['password']), 'val_n_activation' => $validat ));
					
					header("Location: login.php?enregistrement=ok");	
					exit;
				}			
			}
		
		}
		catch (Exception $e) //Si une exeption est levée.
		{
			die('Erreur : '.$e->getMessage());
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>SupLink - Register</title>
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

			<!-- Formulaire d'enregistrement -->
			<form action="#" method="POST" title="Register" onsubmit="return submit_register()"  >
			<fieldset>
			<legend>Register</legend>
				<p>
				<span id="email_register_error" class="error">Your email is not correct !</span><br/>
				<label for="email">E-mail:</label>
				<input id="email" type="email" name="email"/>
				<br/><br/>
				
				<span id="password_register_error" class="error">Passwords are not the same !</span><br/>
				<label for="password">Password:</label>
				<input id="password" type="password" name="password"/>
				<br/><br/><br/>
				
				<label for="confirmation">Confirmation:</label>
				<input id="password2" type="password" name="confirmation"/>
				<br/><br/>
				
				<input type="submit" value="Submit"/>
				</p>
			</fieldset>
			</form>

		<footer><hr><p>@2013 SupLink - A project developped by <a href="http://www.supinfo.com">SUPINFO International University</a></p></footer>

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="suplink.js" ></script>
		
	</body>

</html>
