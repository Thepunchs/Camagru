<?php
session_start();
include ('config/setup.php');
if (isset($_POST['login']) && isset($_POST['passwd']))
{
	$req = $conn->prepare("SELECT actif FROM members WHERE login like :login ");
	$req->execute(array(':login' => $_POST['login'])) && $row = $req->fetch();
	$actif = $row['actif'];
	if ($actif == 1)
	{
		$pass_hash = hash("whirlpool", $_POST['passwd']);
		$req = $conn->prepare('SELECT * FROM members WHERE login=? AND passwd=?');
		$req->execute(array($_POST['login'], $pass_hash));
		if ($req->rowcount() > 0)
		{
			$_SESSION['login'] = $_POST['login'];
			echo "Connexion successfull ! Welcome " . $_POST['login'] . " !";
			header('Location:index.php');
		}
		else
		{
			echo "Error login.\n";
			header('Location:index.php');
		}
	}
	else
	{
		echo "Compte non valide.";
		header('Location:index.php');
	}
}
?>