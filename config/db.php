<?php
try {
    // Define the path to the database file
    $dbFile = __DIR__ . '/../database/tasks.db';

    // Create a new PDO instance for SQLite connection
    $db = new PDO('sqlite:' . $dbFile);

    // Set error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    die("Could not connect to the database: " . $e->getMessage());
}
