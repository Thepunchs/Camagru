<?php
include ('config/setup.php');
if ((isset($_POST['login']) || (isset($_POST['newpasswd']) && isset($_POST['newpasswdconfirm'])) || isset($_POST['email'])) && isset($_POST['passwd']))
{
	if (isset($_POST['newpasswd']) && isset($_POST['newpasswdconfirm']) && !empty($_POST['newpasswd']))
	{
		if ($_POST['newpasswd'] != $_POST['newpasswdconfirm'])
		{
			echo "Incorrect new password && new password confirm.";
			header('refresh:2;url=index.php');
			exit;
		}
		if (strlen($_POST['newpasswd']) < 6)
		{
			echo "Erreur : Nouveau password non sécurisé.";
			header('refresh:2;url=index.php');
			exit;
		}
		$passwdhash = hash("whirlpool", $_POST['passwd']);
		$req = $conn->prepare("SELECT passwd FROM members WHERE login like :login ");
		$req->execute(array(':login' => $_SESSION['login'])) && $row = $req->fetch();
		if ($row['passwd'] !== $passwdhash)
		{
			echo "Incorrect password";
			header('refresh:2;url=index.php');
			exit;
		}
		else 
		{
			$newpasswdhash = hash("whirlpool", $_POST['newpasswd']);
			$req = $conn->prepare("UPDATE members SET passwd=:newpasswd WHERE login like :login");
			$req->bindParam(':newpasswd', $newpasswdhash);
			$req->bindParam(':login', $_SESSION['login']);
			$req->execute();
		}
	}
	if ($row['passwd'] !== $passwdhash)
	{
			echo "Incorrect password";
			header('refresh:2;url=index.php');
			exit;
	}
	if (!empty($_POST['email']))
	{
		$req = $conn->prepare("UPDATE members SET email=:newemail WHERE login like :login");
		$req->bindParam(':newemail', $_POST['email']);
		$req->bindParam(':login', $_SESSION['login']);
		$req->execute();
	}
	if (isset($_POST['login']) && !empty($_POST['login']))
	{
		$req = $conn->prepare("UPDATE members SET login=:newlogin WHERE login like :login");
		$req->bindParam(':newlogin', $_POST['login']);
		$req->bindParam(':login', $_SESSION['login']);
		$req->execute();

		$req = $conn->prepare("UPDATE pictures SET login=? WHERE login=?");
		$req->execute(array($_POST['login'], $_SESSION['login']));

		$req = $conn->prepare("UPDATE likes SET login=? WHERE login=?");
		$req->execute(array($_POST['login'], $_SESSION['login']));

		$req = $conn->prepare("UPDATE comments SET login=? WHERE login=?");
		$req->execute(array($_POST['login'], $_SESSION['login']));


		$_SESSION['login'] = $_POST['login'];
	}
	echo "Modifications ajoutées avec succès !";
	header('refresh:2;url=index.php');
}
?>