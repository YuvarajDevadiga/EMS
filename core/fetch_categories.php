<?php
include 'db.php'; // Include your database connection

header('Content-Type: application/json');

$sql = "SELECT id, name FROM task_categories"; // Adjust the column names if needed
$result = $conn->query($sql);

$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Return JSON response
echo json_encode($categories);
