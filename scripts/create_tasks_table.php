<?php
// Get the absolute path of the script directory
$scriptDir = dirname(__FILE__);

// Define the relative path to the database file
$dbFile = $scriptDir . '/../database/tasks.db';  // Going one level up from scripts to database

try {
    // Create or open the SQLite database
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the tasks table if it doesn't exist
    $query = "
        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            priority INTEGER NOT NULL,
            completed BOOLEAN DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

    // Execute the query to create the table
    $db->exec($query);
    echo "Table created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
