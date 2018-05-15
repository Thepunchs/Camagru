<?php
include ('config/setup.php');

if (isset($_POST['img']) && !empty($_POST['img']) && !empty($_POST['selimg']))
{
	$src = explode(",", $_POST['img'], 2)[1];
	//$path = explode("\\", $_POST['selimg'], 3)[2];
	$image1 = imagecreatefromstring(base64_decode($src));
	$image2 = imagecreatefrompng($_POST['selimg']);
	imagecopy($image1, $image2, 0, 0, 0, 0, 200, 150);

	if (imagepng($image1, "tmp.png") == TRUE)
	{
		file_put_contents("test1", "okay4433");
		$new_src = base64_encode(file_get_contents("tmp.png"));

		$req = $conn->prepare('SELECT * FROM pictures WHERE img=?');
		$req->execute(array($new_src));

		if ($req->rowcount() == 0)
		{

			$req = $conn->prepare('INSERT INTO pictures(login, img) VALUES(?, ?)');
			$req->execute(array($_SESSION['login'], $new_src));
		}
	}

}
else
{
	echo "Error.";
	exit();
}
?>