# Task Management Application

## Overview
This application allows users to manage tasks by adding, updating, completing, and deleting them. It includes priority levels for each task and displays task completion status.

## Features
- Add, complete, and delete tasks
- Set priority levels (Low, Medium, High)
- Display completion status

## Steps
1. Clone the repository.
2. Set up the database connection in `config/db.php`.
3. Run the setup script in `scripts/create_tasks_table.php` to create the SQLite database file and tables.
4. Start a local server: `php -S localhost:8000 -t public`.

### Database Setup
To create the SQLite database and tables, run the following command from the root directory:
```bash
php scripts/create_tasks_table.php

## Dependencies
- PHP 7.4 or above
- jQuery 3.6.0
- SQLite 3


Technical Overview:
The application is a simple web-based task manager built with PHP, JavaScript (jQuery), and SQLite. It utilizes AJAX to asynchronously update task statuses without page reloads.

Key Components:

PHP Backend: Handles task CRUD operations.
SQLite Database: Stores task data, including task name, priority, and completion status.
JavaScript (jQuery): Manages user interactions and sends AJAX requests to update tasks.

Folder Structure:

/config: Contains configuration files for database connection.
/actions: Holds backend scripts for handling add, delete, and complete actions.
/helpers: Contains helper functions used throughout the application.
/public: Frontend files, including HTML, CSS, and JavaScript.


Assumptions and Decisions Document

Assumptions:
Priority levels are Low, Medium, and High, represented by values 1, 2, and 3.
AJAX is used to update task status without a page reload.
Tasks are displayed in priority order by default.

Decisions:
jQuery is used for handling DOM manipulation and AJAX.
SQLite is chosen for simplicity, avoiding the need for a full MySQL setup.

# User Guide

## Overview
This web application allows users to manage tasks by adding, prioritizing, and completing tasks.

## Usage
1. **Add Task**: Enter a task name and priority level, then click "Add Task."
2. **Complete Task**: Click the "Complete" button next to a task.
3. **Delete Task**: Click the "Delete" button next to a task.
4. **View Statistics**: The total number of tasks and completed tasks are displayed at the bottom of the screen.