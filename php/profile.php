<?php
session_start();
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
    </script>
</head>

<body>

<?php 
#$_SESSION["fname"] = "testi";
#echo "Session variables are set.";
?>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html"
            style="color: #0000ff; font-family:'Dosis', sans-serif; font-size: 20px;"><b>CodeSchool</b></a>
          <div id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./html.html">HTML Basics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="./css.html">CSS Basics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="./js.html">JavaScript</a>
              </li>
              <li class="nav-item">
                <!--anchor link added.-->
                <a class="nav-link active" href="./index.html#a">About Us</a>
              </li>
              <li class="nav-item">
                <!--anchor link added.-->
                <a class="nav-link active" href="#b">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container">
      <div id="edit-overlay" style="display: none;">
        <div class="edit-form">
          <form>
            <label for="fname">First name</label><br>
<?php
if($_SESSION['fname'])
  echo ' <input type="text" id="fname" name="fname" value="'.$_SESSION['fname'].'"></input><br>'; ?>
            <label for="lname">Last name</label><br>
            <input type="text" id="lname" name="lname"><br>
            <label for="email">Email</label><br>
            <input type="text" id="email" name="email"><br>
            <label for="paswd">Password</label><br>
            <input type="password" id="paswd" name="paswd"><br>
            <input type="submit" value="Submit" class="save-changes">
          </form>
      </div>
      </div>
        <div class="profile-content">
            <div class="profile-left">
                <div class="profile-picture">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSuaFuoGlCQ3paaCuG1flqnTSTuJevd85-qaQ&usqp=CAU" alt="Profile Picture">
                </div>
                <p>*Nimi*</p>
                <p>*E-Mail*</p>
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