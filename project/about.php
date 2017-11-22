


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
				<?php 
					if(!isset($_SESSION['utilisateur']))
					{
						echo '<li><a href="login.php">Login</a> |</li>
						<li><a href="register.php">Register</a> |</li>';
					}
					else
					{
						echo '<li><a href="dashboard.php">Dashboard</a> |</li>';
					}
				?>
				<li><a href="">About</a></li>
			</ul>
		</div>

		<h1>SupLink - Another Url Shortener</h1>
		<br/><br/><br/>
		
		<div id="about"><p>
		This website has been created in order to make a short link<br/> of your long url you usually use to go on your favorite website.<br/>
		Make sure to create an account,<br/> and you'll be ready to make your own short link right away !
		</p></div>
		 

		<footer><hr><p>@2013 SupLink - A student project developped by <a href="http://www.j-p.work">Gonneau Jean Paul</a></p></footer>

		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="suplink.js" ></script>
		
	</body>

</html>
