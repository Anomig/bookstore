<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 

include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Users.php");

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic input validation
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        if ($user = User::canLogin($email, $password)) {
            $userInstance = new User();
            $userData = $userInstance->getUserByEmail($email);

            // Start session and set user data
            $_SESSION['login'] = true;
            $_SESSION['role'] = $userData['role'];

            // Redirect based on role
            $redirect = ($userData['role'] === 'admin') ? 'admin_dashboard.php' : 'index.php';
            header("Location: $redirect");
            exit();
        } else {
            $error = "Incorrect email or password.";
        }
    }
}
	
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="Login">
		<div class="form_login">
			<form action="" method="post">
				<h2 form__title>Login</h2>

				<?php if ($error): ?>
                <div class="form_error">
                    <p><?= htmlspecialchars($error); ?></p>
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
					<!-- <input type="checkbox" id="rememberMe"><label for="rememberMe" class="label_inline">Remember me</label> -->
				</div>

				<div class="form_field">
					<a href="./signup.php">Sign up</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
