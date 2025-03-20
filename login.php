<?php
session_start();
include "db.php";

$error_message = ""; 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $query->bindParam(":username", $username);
    $query->execute();

    $user = $query->fetch();
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username']; 
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Incorrect username or password.";
        }
    } else {
        $error_message = "Incorrect username or password.";
    }
}

$success_message = "";
if (!empty($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body class="login-body">
    
    <?php
    if (!isset($_SESSION['username'])) {
    ?>
    <div class="login">
        <form action="" method="post" class="login-form" autocomplete="off">
            <div>
                <h1>To-Do List</h1>
                <h3>Log-in</h3>
            </div>
            <?php if (!empty($success_message)) { ?>
                <div class="success-message">
                    Account successfully created! Please log in.
                </div>
            <?php } ?>
            <div style="position: relative;">
                <input type="text" id="username" name="username" placeholder=" " required />
                <label for="username">Username</label>
            </div>            
            <div style="position: relative;">
                <input type="password" id="password" name="password" placeholder=" " required />
                <label for="password">Password</label>
            </div>
            <?php if (!empty($error_message)) { ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>
            <button type="submit">Log In</button>
            <div class="reglink">
                <span>No Account? 
                <a href="register.php" class="reg">Register</a>
            </span>
            </div>
        </form>
        
    </div>
    <?php } ?>
</body>

</html>