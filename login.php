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
   isset($_POST['Password'])){
	$Username 		= get_post('Username');
	$Password 		= get_post('Password');
	$query = "SELECT User.Password FROM User WHERE User.Username='$Username'";
	$result = mysql_query($query);
	if(mysql_num_rows($result)==0){
		echo "Username Does not Exist";
	}
	else{
		$actPass = mysql_fetch_array($result);
		if($actPass{'Password'} == $Password)
			echo "Thanks for Logging in";
		else
			echo "Password Invalid";
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
		  <input type="submit" value="LOGIN" />
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
