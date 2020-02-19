<!doctype html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if(isset($_POST['add_role'])){
	$role_name = $_POST['user_role'];
	$query = "INSERT INTO user_role (rolename) VALUES ('".$role_name."')";
	$result = mysqli_query($conn, $query);
	if($result){
		echo '<script type="text/javascript">alert("User role '. $role_name . ' was added successfully") </script>';
	}
	else{
		echo '<script type="text/javascript">alert("Error") </script>';
	}
}
if(isset($_POST['add_user'])){
	$user = $_POST['username'];
	$role_id = $_POST['select_role'];
	$query2 = "INSERT INTO user (username,role_id) VALUES ('".$user."','".intval($role_id)."')";
	$result2 = mysqli_query($conn, $query2);
	if($result2){
		echo '<script type="text/javascript">alert("User '. $user . ' with '. $role_id . ' role was added successfully") </script>';
	}
	else{
		echo '<script type="text/javascript">alert("Error") </script>';
	}
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test BD</title>
</head>
<body>
	<form method="post">
		<table>
			<h3>User role</h3>
			<tr>
				<td>User role: <input type="text" name="user_role" placeholder="enter user role"></td>
			</tr>
			<tr>
				<td><input type="submit" name="add_role" value="Add Role"></td>
			</tr>
		</table>
	</form>
	<form method="post">
		<table>
			<h3>User</h3>
			<tr>
				<td>Username: <input type="text" name="username" placeholder="enter username"></td>
			</tr>
			<tr>
				<td>
					Chose user role:
					<select name="select_role" id="">
						<?php
						$role_from_db = 'SELECT * FROM user_role';
						$retval = mysqli_query( $conn, $role_from_db);
						if($retval){
							while($row = mysqli_fetch_assoc($retval)) {	?>
								<option value="<?php echo $row['id']; ?>">
									<?php echo $row['rolename']; ?>
								</option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><input type="submit" name="add_user" value="Add user"></td>
			</tr>
		</table>
	</form>
	<table>
		<tr>
			<th>Username</th>
			<th>User role</th>
		</tr>
			<?php
			$user_name = 'SELECT user.username, user_role.rolename FROM user_role INNER JOIN user ON user_role.id=user.role_id';
			$new_data = mysqli_query( $conn, $user_name);
			if($new_data) {
				while ( $row = mysqli_fetch_array( $new_data ) ) { ?>
					<tr>
						<td><?php echo $row['username']; ?></td>
						<td><?php echo $row['rolename']; ?></td>
					</tr>
					<?php
				}
			}
			?>
	</table>
</body>
</html>