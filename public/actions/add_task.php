<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['task_name']);
    $priority = filter_var($_POST['priority'], FILTER_VALIDATE_INT);

    // Validate task name and priority
    if (!empty($name) && $priority && $priority >= 1 && $priority <= 3) {
        // Prepare SQL query to insert a new task
        $stmt = $db->prepare("INSERT INTO tasks (name, priority) VALUES (:name, :priority)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':priority', $priority);

        if ($stmt->execute()) {
            // Redirect back with success message
            header("Location: ../index.php?status=success");
        } else {
            // Redirect back with error message
            header("Location: ../index.php?status=error");
        }
    } else {
        // Redirect back with validation failure
        header("Location: ../index.php?status=invalid");
    }
    exit;
}
