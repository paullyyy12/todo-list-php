<?php
session_start();
include "db.php";

if (isset($_POST['task_name']) && !empty($_POST['task_name'])) {
    $task_name = $_POST['task_name'];
    $user_id = $_SESSION['user_id']; 

    $query = $conn->prepare("INSERT INTO tasks (task_name, user_id) VALUES (:tname, :uid)");
    $query->bindParam(":tname", $task_name);
    $query->bindParam(":uid", $user_id);

    try {
        $query->execute();
        header("Location: index.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
