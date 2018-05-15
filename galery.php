<?php
	include ('config/setup.php');
	include('header.php');
?>

<!DOCTYPE html>
<html>
<body>
	<div class="all_screen_cam"></div>
	<div class="galery">
		<?php
			$req = $conn->prepare('SELECT * FROM pictures ORDER BY id DESC');
			$req->execute();
			while ($row = $req->fetch(PDO::FETCH_ASSOC))
          	{
            	$src = $row['img'];
            	$login = $row['login'];
            	$id = $row['id'];
            	echo "<div class=\"gal_com\"><div class=\"gal_pic\"><p>" . $login . " :</p>
            	<img class=\"border\" src=\"data:image/png;base64," . $src . "\"></div>
            	<form action=\"likes.php\" method=\"post\">
            	<input type=\"hidden\" value=\"" . $id . "\" name=\"img_id\">";

				$like = $conn->prepare('SELECT * FROM likes WHERE img_id=?');
            	$like->execute(array($id));
            	$i = 0;
				while ($rowlike = $like->fetch(PDO::FETCH_ASSOC))
					$i++;
            	echo "<input class=\"likes\" type=\"submit\" value=\"" . $i . "\">
            	</form>
            	<div class=\"combox\">";

            	$com = $conn->prepare('SELECT * FROM comments WHERE img_id=? ORDER BY reg_date DESC');
            	$com->execute(array($id));

            	while ($rowcom = $com->fetch(PDO::FETCH_ASSOC))
            	{
            		echo $rowcom['reg_date'] . " - ";
            		echo $rowcom['login'] . " : ";
            		echo $rowcom['comment'];
            		echo "<br />";
            		echo "<hr>";
            	}

            	echo "</div>
            	<form action=\"comment.php\" method=\"post\">
            	<input type=\"text\" placeholder=\"Your comment\" class=\"com\" name=\"com\">
            	<input type=\"hidden\" value=\"" . $id . "\" name=\"img_id\">
            	<input type=\"submit\" value=\"Send\" class=\"sendcom\">
            	</form>
            	</div>";
          	}
		?>
	</div>
</body>
</html>