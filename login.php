<?php  
    function Login($email, $password){
        if($email == "naomi@shop.be" && $password == "1234"){
            return true;
        }else{
            return false;
        }        
    }

    if(!empty($_POST)){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = Login($email, $password);
        if(Login($email, $password)){
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['email'] = $email;
            header('Location: index.php');
        }else{
            $error = true;
        }
    }

?><!DOCTYPE html>
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
				<h2 form__title>Sign In</h2>

				<?php if(isset($error)): ?>

				<div class="form_error">
					<p>
						Sorry, we can't log you in with that email address and password. Can you try again?
					</p>
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

				<div class="form__field">
					<input type="submit" value="Sign in" class="btn btn_primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label_inline">Remember me</label>
				</div>
			</form>
		</div>
	</div>
</body>
</html>