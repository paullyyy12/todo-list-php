<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

$query = $conn->prepare("SELECT firstname, lastname FROM users WHERE id = :user_id");
$query->bindParam(":user_id", $_SESSION['user_id']);
$query->execute();
$user = $query->fetch();

$firstname = $user['firstname'];
$lastname = $user['lastname'];

$query = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 0 AND user_id = :user_id");
$query->bindParam(":user_id", $_SESSION['user_id']);
$query->execute();
$pendingTasks = $query->fetchAll();

$query = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 1 AND user_id = :user_id");
$query->bindParam(":user_id", $_SESSION['user_id']);
$query->execute();
$completedTasks = $query->fetchAll();

$hasIncomplete = false;
$hasComplete = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My To-Do List</title>
    <link rel="stylesheet" href="./styles.css">
</head> 
<body>
    <aside class="top"> 
        <div class="bannner">
            To-Do List
        </div>
        
    </aside>
    
    <div class="container">
        <aside class="leftside">
            <div class="user-info">
                Welcome, <?= htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname) ?>!
            </div>
            <div class="addtask">
                <form action="add_task.php" method="post" autocomplete="off">
                    <label>New Task</label>
                    <div class="new">
                        <input type="text" name="task_name" id="task_name" placeholder="Enter a new task">
                        <div class="press">
                        <button type="submit" id="submitBtn" disabled>Add Task</button>
                        </div>
                    </div>
                </form>
            </div >
            <a href="#target-section1" >
                <div class="shortcut">Tasks List</div>
            </a>
            <a href="#target-section2">
                <div class="shortcut"> Completed Task</div>
            </a>
            <a class="logout-btn" href="logout.php">
            <div>Logout</div>
        </a>
        </aside>
        <div class="alltask">
            <div class="category" id="target-section1">Tasks List</div>
            <div class="task">
                <?php foreach ($pendingTasks as $tasks) { ?>
                        <?php $hasIncomplete = true; ?>
                        <div class="tasklist">
                            <div class="name">
                                <div class="task-name" id="name-<?= $tasks['id'] ?>"><?= htmlspecialchars($tasks['task_name']) ?></div>
                                <input type="text" class="edit-input" id="input-<?= $tasks['id'] ?>" value="<?= htmlspecialchars($tasks['task_name']) ?>" style="display:none;">
                                <div class="ecdbox">
                                    <div class="ecd">
                                        <a href="#"  onclick="editTask(<?= $tasks['id'] ?>)"><img src="./img/edit.png" alt=""></a>
                                    </div>
                                    <div class="ecdtext">Edit</div>
                                </div>
                            </div>
                            <div class="func">
                                <div class="ecdbox">
                                        <div class="ecd">
                                            <div class="complete"><a href="#" onclick="window.location = 'complete_task.php?id=' + <?= $tasks['id'] ?>"><img src="./img/check-mark.png" alt=""></a></div>
                                        </div>
                                        <div class="ecdtext">Complete</div>
                                </div>
                                <div class="ecdbox">
                                    <div class="ecd">
                                        <div class="delete"><a href="#" onclick="confirm1(<?= $tasks['id'] ?>)"><img src="./img/bin.png" alt=""></a></div>
                                    </div>
                                    <div class="ecdtext">Delete</div>
                                </div>
                            </div>
                        </div>
                <?php } ?>
                <?php if ($hasIncomplete == true) { ?>
                    <div></div>
                <?php } else { ?>
                    <div class="empty">
                        <div><img src="./img/empty-box.png" alt=""></div>
                        <div class="emptyText" id="target-section1">No Task Available</div>
                    </div>
                <?php } ?>
            </div>
            <div class="category" id="target-section2">Completed Task</div>
            <div class="task">
                <?php foreach ($completedTasks as $tasks) { ?>
                    <?php $hasComplete = true; ?>   
                    <div class="tasklist">
                        <div class="compname">
                            <?= htmlspecialchars($tasks['task_name']) ?>
                            <div class="ecdbox">
                                <div class="ecd">
                                    <div class="delete"><a href="#" onclick="confirm1(<?= $tasks['id'] ?>)"><img src="./img/bin.png" alt=""></a></div>
                                </div>
                                <div class="ecdtext">Delete</div>
                            </div>                            
                        </div>
                    </div>
                <?php } ?>
                <?php if ($hasComplete == true) { ?>
                    <div></div>
                <?php } else { ?>
                    <div class="empty">
                        <div><img src="./img/empty-box.png" alt=""></div>
                        <div class="emptyText">No Completed Task</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>