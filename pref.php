<?php
include ('config/setup.php');
if (isset($_POST['yes']))
	{
			$req = $conn->prepare('UPDATE members SET notif=1 WHERE login=?');
			$req->execute(array($_SESSION['login']));
	}
if (isset($_POST['no']))
	{
		$req = $conn->prepare('UPDATE members SET notif=0 WHERE login=?');
		$req->execute(array($_SESSION['login']));
	}
header('Location:index.php');
?>