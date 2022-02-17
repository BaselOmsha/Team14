<?php
    $initials = parse_ini_file("../.ht.asetukset.ini");
    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    $editable = isset($_GET["editable"]) ? $_GET["editable"] : 0;
    if (empty($editable)) {
        header("Location:./admin.php");
        exit();
    }
    try {
        $connection = mysqli_connect($initials["databaseserver"], 
            $initials["username"], $initials["password"], $initials["database"]);
    } catch (Exception $e) {
        header("Location:../html/connectionError.html");
        exit();
    }
    $sql = "select * from users where id=?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $editable);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (! $row = mysqli_fetch_object($result)) {
        header("Location:./admin.php");
        exit();
    }
    include "../html/admin_header.html";
?>
<form  method='post' action='./admin_update.php'>
	<h3>ID:</h3>
		<input class='input' type='text' name='id' value='<?php print $row->id;?>' readonly><br>
	<h3>First name:</h3>
		<input class='input' type='text' name='fname' value='<?php print $row->fname;?>'
		placeholder='Your first name'><br>
	<h3>Last name:</h3>
		<input class='input' type='text' name='lname' value='<?php print $row->lname;?>'
		placeholder='Your last name'><br>
	<h3>Username:</h3>
		<input class='input' type='text' name='uname' value='<?php print $row->uname;?>'
		placeholder='10 characters or less'><br>
	<h3>Email:</h3>
		<input class='input' type='text' name='email' value='<?php print $row->email;?>'
		placeholder='Your email'><br>
	<h3>Password:</h3>
		<input class='input' type='password' name='paswd' value='<?php print $row->paswd;?>'
		placeholder='Create a strong password' id="myInput"><br>
	<p>
		Show Password<input type="checkbox" onclick="myFunction()">
	</p>
	<h3>Description:</h3>
		<input class='input' type='text' name='descrip' value='<?php print $row->descrip;?>'
		placeholder='Description'><br> <br> 
	<input style='font-size: 20px; background-color: #ff7a18; width: 100px'
		type='submit' name='submit' value='Update'>
	<input style='font-size: 20px; background-color: #ff7a18; width: 100px'
		type='reset' name='reset' value='Reset'><br> <br>
	<input style='font-size: 20px; background-color: #ff7a18; width: 100px'
		type='button' name='cancel' value='Cancel' onclick='window.history.back()';><br><br>
</form>
<?php
    mysqli_close($connection);
    include "../html/admin_footer.html";
?>
