<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($id) {
        // Prepare SQL query to mark the task as completed
        $stmt = $db->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Redirect back with success message
            header("Location: ../index.php?status=completed");
        } else {
            // Redirect back with error message
            header("Location: ../index.php?status=error");
        }
    } else {
        // Redirect back with invalid input message
        header("Location: ../index.php?status=invalid");
    }
    exit;
}
