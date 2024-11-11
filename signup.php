<?php  
	include_once(__DIR__ . "/classes/Db.php");
	include_once(__DIR__ . "/classes/Users.php");

    if(!empty($_POST)){
        try{
            $user = new User();
            $user->setFname($_POST['fname']);
            $user->setLname($_POST['lname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);

            if($user->save()){
				header('Location: login.php');
			} else{
				echo "user not saved";
			}
        }
    catch(Exception $e){
        $error = $e->getMessage();
    }
    }


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
						Sorry, we can't sign you in. Can you try again?
					</p>
				</div>
				<?php endif; ?>
                
                
                <div class="form_field">
					<label for="fname">First name</label>
					<input type="text" name="fname">
				</div>
                <div class="form_field">
					<label for="lname">Last name</label>
					<input type="text" name="lname">
				</div>
				<div class="form_field">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>
				<div class="form_field">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

				<div class="form__field">
                    <button value="sign in" class="btn btn_primary">Sign in</button>	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label_inline">Remember me</label>
				</div>

                <div class="form_field">
					<a href="./login.php">Al een account?</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>