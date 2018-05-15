<?php
include ('config/setup.php');

if (isset($_FILES['open']) && !empty($_FILES['open']))
{

	//file_put_contents("yo", print_r($_FILES['open'], true));
	//$path = explode("\\", $_POST['selimg'], 3)[2];
	$src = $_FILES['open']['tmp_name'];
	if (empty($src))
	{
		header('Location:camera.php');
		exit;
	}
	if (!empty($src) && !empty($_POST['sel']) && $_FILES['open']['type'] == "image/png" && $_FILES["fileupload"]["size"] < 5000000)
	{
		$image1 = imagecreatefrompng($src);
		$image2 = imagecreatefrompng($_POST['sel']);
		$image = imagecreatetruecolor(200, 150);
		$width = imagesx($image1); 
		$height = imagesy($image1);
		imagecopyresampled($image, $image1, 0, 0, 0, 0, 200, 150, $width, $height);
		imagecopy($image, $image2, 0, 0, 0, 0, 200, 150);
		imagepng($image, "tmp.png");
		
		$new_src = base64_encode(file_get_contents("tmp.png"));

		$req = $conn->prepare('INSERT INTO pictures(login, img) VALUES(?, ?)');
		$req->execute(array($_SESSION['login'], $new_src));
		
	}
	else
	{
		header('Location:camera.php?error=1');
		exit;
	}

}
header('Location:camera.php');
exit;
?>