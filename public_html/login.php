<?php
	include_once ('../resources/User.php');
	$error = NULL;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$tag = $_POST['user'];
		$pass = $_POST['pass'];
		$user = new User($tag, $pass);
		$error = $user->login();
		if ($error == NULL) {
			header("Location: index.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" media="all"
	href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="all"
	href="css/main.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Game Renegades</h1>
		</div>
		<div id="content"
			style="border-top-left-radius: 4px; border-top-right-radius: 4px; margin-top: 10px;">
			<div class="col-md-12" style="margin-bottom: 20px;">
				<?php
					if ($error) {
						echo '<div class="alert alert-danger" id="login-error">Username and password did not match</div>';
						
					}
				?>
				<form role="form" action="login.php" method="post">
					<div class="form-group">
						<label for="user-name">User Name</label> 
						<input id="user-name" class="form-control" type="text" name="user">
					</div>
					<div class="form-group">
						<label for"password">Password</label>
						<input id="password" class="form-control" type="password"name="pass" />
					</div>
					<button type="submit" id="login" class="btn btn-default">Submit</button>
					<a href="register.php"><button type="button" class="btn btn-default">Register</button></a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>