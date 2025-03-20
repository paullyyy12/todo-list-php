<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $task_name = $_POST["task_name"];

    $stmt = $conn->prepare("UPDATE tasks SET task_name = :task_name WHERE id = :id");
    $stmt->bindParam(":task_name", $task_name);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>