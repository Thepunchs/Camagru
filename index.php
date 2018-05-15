<?php
session_start();
	include('config/setup.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<a href="index.php"><div class="head"> <h1 id="title">Camagruuu</h1></div></a>
</head>
<body class="all_screen_ind">
	<div class="connexion">
		<?php if (!isset($_SESSION['login'])) { ?>
		<h1 id="ind_err"> Vous devez être connecté pour accéder à l'intégralité du site. </h1> <?php } else { ?>
		<h1 id="ind_err" style="color:green;"> Vous êtes connectés en tant que <?php echo $_SESSION['login']; ?>.</h1><br />
		<div class="form" id="modif">
			<h2> Modifier mon compte : </h2>
			<form action="modif.php" method="post">
				<input type="text" name="login" placeholder="New login (max 25 characteres)"><br />
				<input type="password" name="newpasswd" placeholder="New password (min 6 characteres)"><br />
				<input type="password" name="newpasswdconfirm" placeholder="New password Confirm"><br />
				<input type="email" name="email" placeholder="New email"><br />
				<p id="oblig">* Password :</p><input type="password" name="passwd" placeholder="Password"><br />
				<input type="submit" name="submit" value="Change" style="font-size : 20px; color:#4d4d4d;"><br />
			</form>
			<h2> Préférences : </h2>
			<form action="pref.php" method="post">
				<p> Recevoir des notifications par email ?</p><br />
			<?php
					$req = $conn->prepare('SELECT notif FROM members WHERE login=?');
					$req->execute(array($_SESSION['login']));
					$row = $req->fetch(PDO::FETCH_ASSOC);
					// file_put_contents("test1", print_r($row, true));
					if ($row['notif'] == 1) {
			?>
				<input name="no" type="submit" value="No" style="font-size : 20px; color:#4d4d4d;"> <?php } else { ?>
				<input name="yes" type="submit" value="Yes" style="font-size : 20px; color:#4d4d4d;"> <?php } ?>
			</form>
		</div>
		<?php } ?>
		<div class="gauche">
			<a href="camera.php"><div class="buttons">Camera</div></a>
			<a href="galery.php"><div class="buttons">Galery</div></a>
			<a href="index.php"><div class="buttons">My account</div></a>
		</div>

		<?php if (!isset($_SESSION['login'])) { ?>
		<div  class="button1" onclick="afficher_masquer('login')"> Login </div> <br /> <?php } else { ?>
		<div  class="button1"><?php echo $_SESSION['login']; ?> </div> <br /> <?php } ?>
		<?php if (!isset($_SESSION['login'])) { ?>
			<div id="login" class="form">
				Login : <br /><br />
				<form method="post" action="login.php">
				<input type="text" name="login" placeholder="Login"><br />
				<input type="password" name="passwd" placeholder="Password"><br />
				<input type="submit" name="submit" value="Connexion" style="font-size : 20px; color:#4d4d4d;"><br />
			</form>
			<a onclick="afficher_masquer('forgot')">Forgot your password ?</a> <br /><br />
			<div id="forgot">
				<form action="forgotpass.php" method="post"><input type="email" name="email" placeholder="Email">
					<input type="submit" name="submit" value="Reinitialiser" style="font-size : 20px; color:#4d4d4d;"></form>
			</div>
			<br />
			</div> <br /><?php } ?>
			<?php if (!isset($_SESSION['login'])) { ?>
		<div class="button2" onclick="afficher_masquer('register')"> Register </div> <br /> <?php } else { ?>
		<a href="logout.php"><div class="button2"> Logout </div></a> <br /> <?php } ?>
			<?php if (!isset($_SESSION['login'])) { ?>
			<div id="register" class="form">
				Register : <br /><br />
				<form method="post" action="register.php">
				<input type="text" name="login" placeholder="Login (max 25 characteres)"><br />
				<input type="password" name="passwd" placeholder="Password (min 6 characteres)"><br />
				<input type="password" name="passwdconfirm" placeholder="Password Confirm"><br />
				<input type="email" name="email" placeholder="Email"><br />
				<input type="submit" name="submit" value="Register" style="font-size : 20px; color:#4d4d4d;"><br />
				</form>
			</div><?php } ?>
	</div>
	<script>
		function afficher_masquer(id)
		{
  			if (document.getElementById(id).style.display == 'none')
  			{
    			document.getElementById(id).style.display = 'block';
  			}
  			else
  			{
      			document.getElementById(id).style.display = 'none';
  			}
		}
	</script>
</body>
<footer>
	
</footer>
</html>