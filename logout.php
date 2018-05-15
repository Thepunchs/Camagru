<?php
	session_start();
	session_destroy();
	echo "Déconnexion.";
	header('Location:index.php');
?>