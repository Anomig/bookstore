<?php
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Users.php");

$error = '';

if (!empty($_POST)) {
    try {
        // Maak een nieuw User-object
        $user = new User();
        
        // Stel de gebruikersgegevens in
        $user->setFname($_POST['fname']);
        $user->setLname($_POST['lname']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);

        // Sla de gebruiker op in de database
        if ($user->save()) {
            header('Location: login.php');
            exit(); // Zorg ervoor dat de uitvoering stopt na de header
        } else {
            $error = 'User not saved. Please try again.';
        }
    } catch (Exception $e) {
        // Toon specifieke foutmelding als er iets misgaat
        $error = $e->getMessage();
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="Login">
    <div class="form_login">
        <form action="" method="post">
            <h2 class="form__title">Sign Up</h2>

            <?php if ($error): ?>
                <div class="form_error">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <div class="form_field">
                <label for="fname">First Name</label>
                <input type="text" name="fname" required>
            </div>
            
            <div class="form_field">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" required>
            </div>

            <div class="form_field">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form_field">
                <label for="password">Password</label>
                <input type="password" name="password">
            </div>

            <div class="form_field">
                <button type="submit" class="btn btn_primary">Sign Up</button>
            </div>

            <div class="form_field">
                <a href="login.php">Already have an account? Log in</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
