<?php
session_start();
include ('config/setup.php');
if (isset($_POST['del']))
{
	$req = $conn->prepare('DELETE FROM pictures WHERE id=? AND login=?');
	$req->execute(array($_POST['del'], $_SESSION['login']));
}
header('Location:camera.php');
	exit;
?>