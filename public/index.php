<?php
include '../config/db.php';
include '../helpers/functions.php';

// Define pagination parameters
$limit = 5; // Number of tasks per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { $page = 1; }

// Calculate the offset
$offset = ($page - 1) * $limit;

// Fetch tasks for the current page
$tasks = getTasks($db, $limit, $offset);

// Get total number of tasks to calculate total pages
$totalTasks = getTotalTasks($db);
$totalPages = ceil($totalTasks / $limit);
$completedTasks = countCompletedTasks($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.scss"> <!-- Change to a compiled CSS file if needed -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>

        <!-- Display status messages -->
        <?php if (isset($_GET['status'])): ?>
            <div class="status-message <?php echo $_GET['status']; ?>">
                <span class="status-icon"></span>
                <?php
                $status = $_GET['status'];
                if ($status == 'success') {
                    echo "<p>Task added successfully!</p>";
                } elseif ($status == 'error') {
                    echo "<p>There was an error processing your request.</p>";
                } elseif ($status == 'deleted') {
                    echo "<p>Task deleted successfully!</p>";
                } elseif ($status == 'completed') {
                    echo "<p>Task marked as completed!</p>";
                } elseif ($status == 'invalid') {
                    echo "<p>Invalid input. Please check your data.</p>";
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Form to add a task -->
        <div class="form-container">
            <form action="actions/add_task.php" method="POST" id="task-form">
                <input type="text" name="task_name" id="task-name" placeholder="Enter task name" required class="task-input">
                <select name="priority" id="priority" class="task-priority">
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                </select>
                <button type="submit" class="btn-add-task">Add Task</button>
            </form>
        </div>

        <!-- Display tasks -->
        <h2>Tasks</h2>
        <div class="tasks-container">
            <?php if ($tasks): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li class="task-item <?php echo $task['completed'] ? 'completed' : ''; ?>" data-priority="<?php echo $task['priority']; ?>" id="task_<?php echo $task['id']; ?>">
                            <span class="task-name"><?php echo htmlspecialchars($task['name']); ?></span> - 
                            <span class="task-priority">Priority: 
                                <?php 
                                    switch ($task['priority']) {
                                        case 1:
                                            echo 'Low';
                                            break;
                                        case 2:
                                            echo 'Medium';
                                            break;
                                        case 3:
                                            echo 'High';
                                            break;
                                        default:
                                            echo 'Unknown';
                                    }
                                ?>
                            </span>
                            <div class="task-actions">
                                <button class="complete-task btn-complete" data-id="<?php echo $task['id']; ?>" <?php echo $task['completed'] ? 'disabled' : ''; ?>>Complete</button>
                                <form action="actions/delete_task.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tasks available.</p>
            <?php endif; ?>
        </div>

         <!-- Pagination Controls -->
         <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php
                // Display page links
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $page) {
                        echo "<span class='current-page'>{$i}</span>";
                    } else {
                        echo "<a href='?page={$i}'>{$i}</a>";
                    }
                }
                ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Display task statistics -->
        <div class="stats">
            <p>Total tasks: <strong><?php echo $totalTasks; ?></strong></p>
            <p>Completed tasks: <strong><?php echo $completedTasks; ?></strong></p>
        </div>
    </div>

     <!-- Task Completion Modal -->
     <div id="complete-modal" class="modal">
        <div class="modal-content">
            <h3>Are you sure you want to mark this task as completed?</h3>
            <button id="complete-confirm" class="btn-confirm">Yes</button>
            <button id="complete-cancel" class="btn-cancel">No</button>
        </div>
    </div>

    <!-- Task Deletion Modal -->
    <div id="delete-modal" class="modal">
        <div class="modal-content">
            <h3>Are you sure you want to delete this task?</h3>
            <button id="delete-confirm" class="btn-confirm">Yes</button>
            <button id="delete-cancel" class="btn-cancel">No</button>
        </div>
    </div>

    <script src="js/tasks.js"></script>
</body>
</html>
