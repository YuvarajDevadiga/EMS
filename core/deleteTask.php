<?php
header("Content-Type: application/json");
include "db.php"; // Database connection

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id"])) {
    $id = $data["id"];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Task deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete task"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

$conn->close();
