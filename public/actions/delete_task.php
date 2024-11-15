<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($id) {
        // Prepare SQL query to delete the task
        $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Redirect back with success message
            header("Location: ../index.php?status=deleted");
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
