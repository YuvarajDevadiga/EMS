<?php
include "db.php"; // Include your database connection

header("Content-Type: application/json");


$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST["task_id"];
    $status = $_POST["status"];
    // file_put_contents("debug.log", print_r($task_id, true));
    if (empty($task_id) || empty($status)) {
        $response["status"] = "error";
        $response["message"] = "Task ID and status are required.";
        echo json_encode($response);
        exit();
    }

    // Update task status
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $task_id);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Task status updated successfully.";
    } else {
        $response["status"] = "error";
        $response["message"] = "Failed to update status.";
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
