<?php
include 'db.php';

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);
// file_put_contents("debug.log", print_r($data, true));
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($data)) {

    $taskName = $data['title'];  // Adjust keys to match JSON structure
    $taskDescription = $data['description'];
    $assignedUser = $data['assigned_to'];
    $dueDate = $data['due_date'];
    $category = $data['category_id']; // Match with formData key


    // Make sure task ID is passed correctly (you didn't include it in AJAX)
    $taskId = $data['id'] ?? null;

    if (!$taskId) {
        echo json_encode(["error" => "Task ID is missing"]);
        exit;
    }
    error_log(print_r($data, true));
    // Prepare update query
    $query = "UPDATE tasks SET title=?, description=?, assigned_to=?, due_date=?, category_id=? WHERE id=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisii", $taskName, $taskDescription, $assignedUser, $dueDate, $category, $taskId);


    if ($stmt->execute()) {
        echo json_encode(["message" => "Task updated successfully!"]);
    } else {
        echo json_encode(["error" => "Error updating task."]);
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
}
