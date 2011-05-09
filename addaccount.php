<?php
require_once 'sql_login.php';

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db("achates",$dbhandle)
  or die("Could not select Works");

//*
if(isset($_POST['Username']) 		&&
   isset($_POST['Password'])		&&
   isset($_POST['Email'])){
	$Username 		= get_post('Username');
	$Password 		= get_post('Password');
	$Email	 		= get_post('Email');
	$chkUN = "SELECT User.Username FROM User WHERE User.Username='$Username'";
	$result = mysql_query($chkUN);
	$chkEM = "SELECT User.Email FROM User WHERE User.Email='$Email'";
	$result2 = mysql_query($chkEM);
	if(mysql_num_rows($result)+mysql_num_rows($result2)==0){
		$query = "INSERT INTO User (UserID, Username, Password, email) VALUES" . " (NULL,'$Username', '$Password', '$Email')";
		if(!mysql_query($query,$dbhandle))
			echo "INSERT failed: $query<br/>" . mysql_error() . "<br/><br/>";
	}
	elseif(mysql_num_rows($result)>0){
		echo "That User Already Exists";
	}
	elseif(mysql_num_rows($result2)>0){
		echo "That Email is Already in use";
	}
	
}
//*/
//*
if(isset($_POST['UserID'])	&&
   isset($_POST['delete']) 		){
	$UserID 	= get_post('UserID');
	$query = "DELETE FROM User WHERE UserID = '$UserID'";
	if(!mysql_query($query))
			echo "DELETE failed: $query<br/>" . mysql_error() . "<br/><br/>";
}//*/

echo <<<_END
<form action = "login.php" method ="post"><pre>
   Username <input type="text" name = "Username"/>
   Password <input type="text" name = "Password" />
      Email <input type="text" name = "Email"/>
		  <input type="submit" value="ADD RECORD" />
</pre></form>
_END;


$result = mysql_query("SELECT  User.UserID, User.Username, User.Password
		FROM User
		ORDER BY User.Username");
?>
<html><head><title>DB Test</title></head>
<body>
<table border = 1> 
<tr><th>Username</th><th>Password</th></tr>
<?php 
while($row = mysql_fetch_array($result)){
?>
	<tr><td><?php echo $row{'Username'} ?></td>
		<td><?php echo $row{'Password'} ?></td>
		<td>
			<form action="login.php" method="post">
				<input type="hidden" name = "delete" value = "yes"/>
				<input type="hidden" name = "UserID" value = "<?php echo $row{'UserID'} ?>"/>
				<input type = "submit" value="DELETE RECORD" />
			</form>
		</td>
	</tr>
<?php 
}
mysql_close($dbhandle);
?>
</table>
</body>
