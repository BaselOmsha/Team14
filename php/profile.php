<?php
session_start();
$initials=parse_ini_file("../.ht.asetukset.ini");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
#$_SESSION["user"] = "tester";
if(isset($_SESSION["user"])) {
} else {
  header("Location:../html/connectionError.html");
}
try{
    $yhteys=mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
}
catch(Exception $e){
    header("Location:../html/connectionError.html");
    exit;
}

$user=$_SESSION["user"];




$query=mysqli_query($yhteys, "select * from users where uname='$user'");
$row = mysqli_fetch_object($query);
$firstname="$row->fname";
$lastname="$row->lname";
$email="$row->email";
$picpath="$row->profpic";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Santeri Passi">
    <meta name="description"
        content="CodeSchool user profile page">
    <title>Main Page</title>
    <!--Link to bootstrap.-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css"><!--Link to local css file.-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">
    <script>
      function toggleOverlay() {
        var x = document.getElementById("edit-overlay");
        if (window.getComputedStyle(x).display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }
      }
      
      function lahetaKayttaja(lomake){
		var user=new Object();
		user.tunnus=lomake.tunnus.value;
		user.salasana=lomake.salasana.value;
		var jsonUser=JSON.stringify(user);
	
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
	  		if (this.readyState == 4 && this.status == 200) {
		    	document.getElementById("result").innerHTML = this.responseText;
	  		}
		};
		xmlhttp.open("POST", "../php/rekisteroidyajax.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("user=" + jsonUser);	
		}
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="../html/index.html"
            style="color: #0000ff; font-family:'Dosis', sans-serif; font-size: 20px;"><b>CodeSchool</b></a>
          <div id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../html/html.html">HTML Basics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../html/css.html">CSS Basics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../html/js.html">JavaScript</a>
              </li>
              <li class="nav-item">
                <!--anchor link added.-->
                <a class="nav-link active" href="../html/index.html#a">About Us</a>
              </li>
              <li class="nav-item">
                <!--anchor link added.-->
                <a class="nav-link active" href="../html/index.html#b">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container">
      <div id="edit-overlay" style="display: none;">
        <div class="edit-form">
       <form method="POST" action="edit_profile.php"">
            <label for="fname">First name</label><br>
<?php
echo ' <input type="text" id="fname" name="fname" value="'.$firstname.'"></input><br>'; ?>
            <label for="lname">Last name</label><br>
<?php
echo ' <input type="text" id="lname" name="lname" value="'.$lastname.'"></input><br>'; ?>
            <label for="email">Email</label><br>
<?php
echo ' <input type="text" id="email" name="email" value="'.$email.'"></input><br>'; ?>
            <input type="submit" value="Submit" class="edit" name="edit">
          </form>
      </div>
      </div>
        <div class="profile-content">
            <div class="profile-left">
            <?php echo '<p>'.$firstname.' '.$lastname.'<p>'?>
                <div class="profile-picture">
                    <?php 
                    if(empty($picpath)) {
                        echo '<img src="../profilepics/default.png" alt="Profile Picture">';
                    } else {
                        echo '<img src="'.$picpath.'" alt="Profile Picture">';
                    }
                    ?>
                </div>
                <div class="uploadimg">
                	<form method="POST" action="upload.php" enctype="multipart/form-data">
                	<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
                	<input type="submit" value="Upload Image" name="submit"><br><br>
                	</form>
                </div>
                <button onclick="toggleOverlay()">Edit Profile</button>
            </div>
            <div class="profile-right">
                <div class="bio">
                    <h2 class="biotitle">Bio</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo elit nec aliquam pellentesque. Donec auctor odio eu urna viverra ullamcorper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent blandit sollicitudin ante. Vivamus ullamcorper suscipit porttitor. Phasellus iaculis in elit eu vehicula. Fusce iaculis vehicula venenatis. Fusce non tincidunt ligula. Curabitur nec consequat arcu. Sed mollis eu ligula sit amet tristique.</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>