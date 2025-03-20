<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $stmt = $conn->prepare("UPDATE tasks SET is_completed=1 WHERE id=:id");
    $stmt->bindParam(":id", $_GET['id']);
    try {
        $stmt->execute();
        header("Location: index.php");
    } catch (\Throwable $th) {
        echo "Something went wrong.";
    }
}