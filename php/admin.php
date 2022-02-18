<?php
session_start();
if (! isset($_SESSION["admin"])) {
    $_SESSION["returnSite"] = "/php/admin.php";
    header("Location:../html/admin_login.html");
    exit();
}
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$initials = parse_ini_file("../.ht.asetukset.ini");
try {
    $connection = mysqli_connect($initials["databaseserver"], $initials["username"], $initials["password"], $initials["database"]);
} catch (Exception $e) {
    header("Location:../html/connectionError.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="Basil Omsha">
<meta name="description"
	content="Team 14 project work. The website contains basic web development guides utilizing HTML5, CSS, JavaScript and Bootstrap">
<title>admin</title>
<!--Link to bootstrap.-->
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
	rel="stylesheet"
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
	crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<!--Link to local css file.-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap"
	rel="stylesheet">
</head>
<body>
	<header>
		<!--navigation bar starts here.-->
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="../html/index.html"
					style="color: #0000ff; font-family: 'Dosis', sans-serif; font-size: 20px;"><b>CodeSchool</b></a>
				<div id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item"><a class="nav-link active"
							aria-current="page" href="../html/html.html">HTML Basics</a></li>
						<li class="nav-item"><a class="nav-link active"
							href="../html/css.html">CSS Basics</a></li>
						<li class="nav-item"><a class="nav-link active"
							href="../html/js.html">JavaScript</a></li>
						<li class="nav-item">
							<!--anchor link added.--> <a class="nav-link active" href="../html/index.html#a">About
								Us</a>
						</li>
						<li class="nav-item">
							<!--anchor link added.--> <a class="nav-link active" href="#b">Contact
								Us</a>
						</li>
						<li class="nav-item">
							<!--anchor link added.--> <a class="nav-link active"
							href="../php/admin_logout.php">Log out</a>
						</li>

					</ul>
				</div><div><b><?php print "Welcome, " . $_SESSION["admin"] . "!";?></b></div> 
			</div>
		</nav>
	</header>
	<!--navigation bar ends here.-->
	<main>
		<!--box with search bar starts here.-->
		<div class="box" style="background-color: #2f303a; color: white">
			<h1 class="padding">
				<b>Welcome to the Admin Page</b>
			</h1>
			<br>
			<h1 class="padding">
				<b>Here you can edit users' data and/or remove profiles from the
					database</b>
			</h1>
			<br>
			<button onclick="toggleOverlay()"><a href="#"><b>Edit Your Profile Here</b></a></button>
		</div>
		<!--box with search bar ends here.-->
		<!--other content.-->
		<div class="sec1">
			<h1 class="padding">
				<b>Users list:</b>
			</h1>
			<br>

			<div class="sec">
 <?php
// getting result from database
$print = mysqli_query($connection, "SELECT * FROM users");
echo "<div class='block'>";
echo "<table>";
echo "<tr>";
echo "<th><h2>ID</h2></th>";
echo "<th><h2>First Name</h2></th>";
echo "<th><h2>last Name</h2></th>";
echo "<th><h2>User Name</h2></th>";
echo "<th><h2>Email</h2></th>";
echo "<th><h2>Password</h2></th>";
echo "<th><h2>Description</h2></th>";
echo "<th><h2>Delete</h2></th>";
echo "<th><h2>Edit</h2></th>";
echo "</tr>";
while ($row = mysqli_fetch_object($print)) {
    echo "<tr>";
    echo "<td><h3>$row->id</h3></td>";
    echo "<td><h3>$row->fname</h3></td>";
    echo "<td><h3>$row->lname</h3></td>";
    echo "<td><h3>$row->uname</h3></td>";
    echo "<td><h3>$row->email</h3></td>";
    echo "<td><h3>$row->paswd</h3></td>";
    echo "<td><h3>$row->descrip</h3></td>";
    echo "<td><h3><a href='./admin_remove.php?deletable=
            $row->id'>Delete</a></h3></td>";
    echo "<td><h3><a href='./admin_edit.php?editable=
            $row->id'>Edit</a></h3></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
mysqli_close($connection);
?>

<?php
include "../html/admin_footer.html";
?>
