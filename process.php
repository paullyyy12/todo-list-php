<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: register.php");
        exit;
    }

    $hashpass = password_hash($password, PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (firstname, lastname, username, password) 
                             VALUES (:fname, :lname, :username, :pw)");

    $query->bindParam(":fname", $firstname);
    $query->bindParam(":lname", $lastname);
    $query->bindParam(":username", $username);
    $query->bindParam(":pw", $hashpass);

    try {
        $query->execute();
        $_SESSION['success_message'] = "Registration successful! You can now log in.";
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['error_message'] = "Username already exists. Please choose another.";
        } else {
            $_SESSION['error_message'] = "Something went wrong. Please try again.";
        }
        header("Location: register.php");
        exit;
    }
}
