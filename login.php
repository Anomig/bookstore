<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 

include_once('C:\\app\\classes\\Db.php');
echo "Current directory: " . __DIR__;
var_dump(__DIR__); // Check the current directory
var_dump(file_exists(__DIR__ . '/classes/Db.php')); // Check if the Db.php file exists at this path
include_once(__DIR__ . "/classes/Users.php");

if(!empty($_POST)){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(User::canLogin($email, $password)){
	
		$user = new User();
		$userData = $user->getUserByEmail($email);
	
		$_SESSION['login'] = true;
		$_SESSION['role'] = $userData['role'];  // Role wordt hier ingesteld.
			
		if($userData['role'] == 'admin'){
			header('Location: admin_dashboard.php');
			exit();
		} else {
			header('Location: index.php');
			exit();
		}
		exit();
	} else {
		$error = true;
		echo "Incorrect login details.";
	}
}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="Login">
		<div class="form_login">
			<form action="" method="post">
				<h2 form__title>Login</h2>

				<?php if (isset($error)): ?>
				<div class="form_error">
					<p>Sorry, we can't log you in with that email address and password. Can you try again?</p>
				</div>
				<?php endif; ?>

				<div class="form_field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>
				<div class="form_field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

				<div class="form_field">
					<input type="submit" value="Sign in" class="btn btn_primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label_inline">Remember me</label>
				</div>

				<div class="form_field">
					<a href="./signup.php">Sign up</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
