<?php
	include ('config/setup.php');
$login = $_GET['log'];
$cle = $_GET['cle'];

$req = $conn->prepare("SELECT cle,actif FROM members WHERE login like :login ");
if($req->execute(array(':login' => $login)) && $row = $req->fetch())
  {
    $clebdd = $row['cle'];
    $actif = $row['actif'];
  }
if($actif == '1')
     echo "Votre compte est déjà actif !";
else
  {
     if($cle == $clebdd)
       {	
          echo "Votre compte a bien été activé !";
          $req = $conn->prepare("UPDATE members SET actif = 1 WHERE login like :login ");
          $req->bindParam(':login', $login);
          $req->execute();
          $_SESSION['login'] = $login;
          header('Location:valideok.php');
       }
     else
          echo "Erreur ! Votre compte ne peut être activé...";
  }
?>