<?php
session_start();
include ('config/setup.php');
if (strlen($_POST['passwd']) < 6)
{
	echo "Password non sécurisé.";
	header('refresh:2;url=index.php');
	exit;
}
$req = $conn->prepare('SELECT * FROM members WHERE email=?');
$req->execute(array($_POST['email']));
if ($req->rowcount() > 0)
{
	echo "Cet email est déjà pris.";
	header('refresh:2;url=index.php');
	exit;
}
$req = $conn->prepare('SELECT * FROM members WHERE login=?');
$req->execute(array($_POST['login']));
if ($req->rowcount() > 0)
{
	echo "Ce login est déjà pris.";
	header('refresh:2;url=index.php');
}
else
{
	if ($_POST['submit'] == "Register" && isset($_POST['login']) && isset($_POST['passwd']) && $_POST['passwd'] === $_POST	['passwdconfirm'] && isset($_POST['email']))
	{
		$pass_hash = hash("whirlpool", $_POST['passwd']);
		$req = $conn->prepare('INSERT INTO members(login, passwd, email) VALUES(?, ?, ?)');
		$req->execute(array($_POST['login'], $pass_hash, $_POST['email']));
		echo("Creation successfull " . $_POST['login'] . " ! You should valid your account ...");

///////////////// VALIDATION EMAIL ////////////////////////
	$email = $_POST['email'];
	$login = $_POST['login'];
	$cle = md5(microtime(TRUE)*100000);

	$req = $conn->prepare("UPDATE members SET cle=:cle WHERE login like :login");
	$req->bindParam(':cle', $cle);
	$req->bindParam(':login', $login);
	$req->execute();

	$sujet = "CAMAGRU - Activer votre compte";
	$entete = "From: inscription@camagru.42.com";
	$message = 'Bienvenue sur Camagru,
 
	Pour activer votre compte, veuillez cliquer sur le lien ci dessous
	ou copier/coller dans votre navigateur internet.
 
	127.0.0.1/cam/activation.php?log='.urlencode($login).'&cle='.urlencode($cle).'
 

	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';
 	mail($email, $sujet, $message, $entete);
 ///////////////////// FIN VALIDATION EMAIL //////////////////////////

	 	header('Location:validation.php');
	 }
	else
	{
		echo("Error. Incorrect things.");
	 	header('Location:index.php');
	}
}
?>