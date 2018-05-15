<?php 
	include('config/setup.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<a href="index.php"><div class="head"><h1 id="title">Camagruuu</h1></div></a>
</head>
<body>
	<div class="connexion">
		<?php if (!isset($_SESSION['login'])) { ?>
		<a href="index.php"><div  class="button1"> Login </div></a> <br /> <?php } else { ?>
		<div  class="button1"><?php echo $_SESSION['login']; ?> </div> <br /> <?php } ?>

		<?php if (!isset($_SESSION['login'])) { ?>
		<a href="index.php"><div class="button2"> Register </div></a> <br /><?php } else { ?>
		<a href="logout.php"><div class="button2"> Logout </div></a> <?php } ?>

		<div class="gauche">
			<a href="camera.php"><div class="buttons">Camera</div></a>
			<a href="galery.php"><div class="buttons">Galery</div></a>
			<a href="index.php"><div class="buttons">My account</div></a>
		</div>
	</div>
</body>
<footer>
	
</footer>
</html>