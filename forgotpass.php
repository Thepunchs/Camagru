<?php
	include ('config/setup.php');
$email = $_POST['email'];

$req = $conn->prepare("SELECT actif,login FROM members WHERE email like :email ");
$req->execute(array(':email' => $email)) && $row = $req->fetch();
$actif = $row['actif'];
$newpass = md5(microtime(TRUE)*100000);
if($actif == '1')
{
     $newpass_hash = hash("whirlpool", $newpass);
     $req = $conn->prepare("UPDATE members SET passwd = :newpass WHERE email like :email ");
     $req->bindParam(':email', $email);
     $req->bindParam(':newpass', $newpass_hash);
     $req->execute();

       //////// ENVOYER LEMAIL ICI /////////
  $sujet = "CAMAGRU - Reinitialiser votre mot de passe";
  $entete = "From: reinitialisation@camagru.42.com";
  $message = 'Bienvenue sur Camagru,
 
  Vous avez demandé une réinitialisation de mot de passe.
  Votre nouveau mot de passe : ' . $newpass . '

   ---------------
   Ceci est un mail automatique, Merci de ne pas y répondre.';
  mail($email, $sujet, $message, $entete);
  header('Location:index.php');
}
else
    {
      echo "Action impossible, compte non valide.";
      header('refresh:2;url=index.php');
    }
?>