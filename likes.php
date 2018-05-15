<?php
include ('config/setup.php');
if (!empty($_SESSION['login']) && isset($_SESSION['login']))
{
if (isset($_POST['img_id']) && !empty($_POST['img_id']))
{
	$req = $conn->prepare('SELECT * FROM likes WHERE login=? AND img_id=?');
	$req->execute(array($_SESSION['login'], $_POST['img_id']));
	if ($req->rowcount() > 0)
	{
		$req = $conn->prepare('DELETE FROM likes WHERE login=? AND img_id=?');
		$req->execute(array($_SESSION['login'], $_POST['img_id']));
	}
	else
	{
		$req = $conn->prepare('INSERT INTO likes(img_id, login) VALUES(?, ?)');
		$req->execute(array($_POST['img_id'], $_SESSION['login']));
	}
}
else
	header('Location:galery.php?error');
}
header('Location:galery.php');
?>