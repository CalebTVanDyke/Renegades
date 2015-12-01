<?php
	include_once ('../resources/User.php');
	$error = NULL;
	session_start();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$tag = $_POST['user'];
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$confirm = $_POST['confirm-password'];
		if ($pass != $confirm) {
			$error = "Passwords did not match.";
		} else {
			$user = new User($tag, $pass, $email);
			$error = $user->addUser();
			if ($error == NULL) {
				header("Location: index.php");
				exit();
			}
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
					if ($error != NULL) {
						echo '<div class="alert alert-danger" id="login-error">'.$error.'</div>';
						
					}
				?>
				<form role="form" action="register.php" method="post">
					<div class="form-group">
						<label for="user-name">User Name</label> 
						<input id="user-name" class="form-control" type="text" name="user">
					</div>
					<div class="form-group">
						<label for="user-name">Email</label> 
						<input id="email" class="form-control" type="text" name="email">
					</div>
					<div class="form-group">
						<label for"password">Password</label>
						<input id="password" class="form-control" type="password"name="password" />
					</div>
					<div class="form-group">
						<label for"password">Confirm Password</label>
						<input id="confirm-password" class="form-control" type="password"name="confirm-password" />
					</div>
					<button type="submit" id="login" class="btn btn-default">Submit</button>
					<a href="login.php"><button type="button" class="btn btn-default">Already a user?</button></a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>