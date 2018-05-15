<?php
include ('config/setup.php');
if (!empty($_SESSION['login']) && isset($_SESSION['login']))
{
if (isset($_POST['com']) && !empty($_POST['com']))
{
	$req = $conn->prepare('INSERT INTO comments(img_id, login, comment) VALUES(?, ?, ?)');
	$req->execute(array($_POST['img_id'], $_SESSION['login'], $_POST['com']));


	$req = $conn->prepare('SELECT * FROM pictures WHERE id=?');
	$req->execute(array($_POST['img_id']));
	$row = $req->fetch(PDO::FETCH_ASSOC);
	$login = $row['login'];

	$req = $conn->prepare('SELECT * FROM members WHERE login=?');
	$req->execute(array($login));
	$row = $req->fetch(PDO::FETCH_ASSOC);
	$email = $row['email'];
	//file_put_contents("test1", $email);

	$sujet = "CAMAGRU - Vous avez un nouveau commentaire !";
	$entete = "From: alefebvr@camagru.42.com";
	$message = 'Bonjour ' . $login . ',
 
	Vous avez un nouveau commentaire sur une photo que vous avez publié
 
	127.0.0.1/cam/galery.php
 

	---------------
	Ceci est un mail automatique, Merci de ne pas y répondre.';

	$req = $conn->prepare('SELECT * FROM members WHERE login=?');
	$req->execute(array($_SESSION['login']));
	$row = $req->fetch(PDO::FETCH_ASSOC);
	if ($row['notif'] == 1)
 		mail($email, $sujet, $message, $entete);
	
}
else
	header('Location:galery.php?error');
}
header('Location:galery.php');
?>