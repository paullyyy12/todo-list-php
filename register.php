<?php
session_start();
$error_message = '';
if (!empty($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body class="register-body">
    <div class="register">
        <form action="process.php" method="post" class="register-form" autocomplete="off">
            <div>
                <h1>To-Do List</h1>
                <h3>Register</h3>
            </div>
            <div style="position: relative;">
                <input type="text" name="firstname" id="firstname" placeholder=" " required />
                <label for="firstname">First Name</label>
            </div>
            <div style="position: relative;">
                <input type="text" name="lastname" id="lastname" placeholder=" " required />
                <label for="lastname">Last Name</label>
            </div>
            <div style="position: relative;">
                <input type="text" name="username" id="username" placeholder=" " required />
                <label for="username">Username</label>
            </div>
            <div style="position: relative;">
                <input type="password" name="password" id="password" placeholder=" " required />
                <label for="password">Password</label>
            </div>
            <?php if (!empty($error_message)) { ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php } ?>
            <button type="submit">Register</button>
            <div class="reglink">
                <span>Already have an account? 
                <a href="login.php" class="reg">Log In</a>
                </span>
            </div>
        </form>
    </div>
</body>

</html>