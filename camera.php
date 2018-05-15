<?php
  include ('config/setup.php');
	include('header.php');
?>

<!DOCTYPE html>
<html>
<body>
	<div class="all_screen_cam"></div>
  <?php if (isset($_SESSION['login']) && !empty($_SESSION['login'])) { ?>
	<div class="cam">
		<video id="video"></video>
		<button id="startbutton" onclick="phoo();" disabled='disabled'>Prendre une photo</button>
      <form class="select" method="post" action="upload.php" enctype="multipart/form-data">
        <img src="img/camag_photo1.png" class="select_img" onclick="radio_activ('radio0'); verif();"></img><input onclick="verif();" id="radio0" name="sel" value="img/camag_photo1.png" type="radio">
        <img src="img/camag_photo2.png" class="select_img" onclick="radio_activ('radio1'); verif();"></img><input onclick="verif();" id="radio1" name="sel" value="img/camag_photo2.png" type="radio">
        <img src="img/camag_photo4.png" class="select_img" onclick="radio_activ('radio2'); verif();"></img><input onclick="verif();" id="radio2" name="sel" value="img/camag_photo4.png" type="radio">
        <input type="file" name="open" id="open" class="choose" onclick="verif();"><p style="margin-top: 0px;">(type: PNG)</p>
		<div class="apercu">
		<h2 id="title_apercu">Aperçu :</h2>
    <div class="can">
		<canvas id="canvas"></canvas>
  <!-- <form> -->
    <!-- <img src="" id="photo" name="photo"> -->
    <input type="submit" id="save" name="submit" value="save" style="width: 100px; height: 30px;" onclick="sendPic()"> 
    <?php if ($_GET['error'] == '1') { ?> <p style="margin-left:200px;color:white;font-size: 20px;"> Error </p> <?php } ?>
  </form>

  <!-- </form> -->
	</div>
	<div class="stock">
      <h3 class="pics">Your pictures :</h3>
      <!-- <img class="pic" src="" id="img"> -->
      <?php
        $req = $conn->prepare('SELECT * FROM pictures WHERE login=? ORDER BY id DESC');
        $req->execute(array($_SESSION['login']));
        if ($req->rowcount() > 0)
        {
          while ($row = $req->fetch(PDO::FETCH_ASSOC))
          {
            $src = $row['img'];
            echo "<div class=\"pic\">
            <form action=\"delete.php\" method=\"post\">
            <input id=\"del\" src=\"img/croix.png\" type=\"image\" name=\"del\" value=\"" . $row['id'] . "\">
            </form>
            <img src=\"data:image/png;base64," . $src . "\"></img></div>";
          }
        }
      ?>

	</div>
  <?php } else { ?>
    <h1 style="color:green; position:absolute; top:230px; left:250px;"> Vous devez être connecté pour accéder à cette page. </h1> <?php } ?>
<script>
  var ok = 0;
  function phoo()
  {
    ok = 1;
  }
  setInterval(verif, 1000);
  function verif() {
    console.log(ok);
      if (document.getElementById('radio0').checked == false && document.getElementById('radio1').checked == false && document.getElementById('radio2').checked == false)
      {
        document.getElementById('startbutton').disabled = 'disabled';
        document.getElementById('save').disabled = 'disabled';
      }
      else if (document.getElementById('open').value || ok == 1)
      {
        document.getElementById('save').disabled = '';
      }
  }

    function radio_activ(id) {
      img = document.getElementById(id);
      img.checked = true;
      document.getElementById('startbutton').disabled = '';
    }

    function sendPic() {
      if (document.getElementById('open').value)
        return;
       var path_img = "";
       if (document.getElementById('radio0').checked == true)
         path_img = 'img/camag_photo1.png';
       else if (document.getElementById('radio1').checked == true)
         path_img = 'img/camag_photo2.png';
       else if (document.getElementById('radio2').checked == true)
         path_img = 'img/camag_photo4.png';
        var image_data = document.getElementById("canvas").toDataURL();
      var xhr = new XMLHttpRequest();
      xhr.open("POST", '/cam/stock.php', true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("img=" + encodeURIComponent(image_data) + "&selimg=" + encodeURIComponent(path_img));
      document.location.href = 'camera.php';
    }


	(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      canvas       = document.querySelector('#canvas'),
      startbutton  = document.querySelector('#startbutton'),
      width = 600,
      height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.srcObject = stream;
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', 200);
      canvas.setAttribute('height', 150);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.width = 200;
    canvas.height = 150;
    canvas.getContext('2d').drawImage(video, 0, 0, 200, 150);
    var data = canvas.toDataURL('image/png');
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

})();
</script>
</body>