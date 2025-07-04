<?php
header("Content-Type: application/json");
include "db.php"; // Database connection

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);
// file_put_contents("debug.log", print_r($data, true));


if (
    isset(
        $data["title"],
        $data["description"],
        $data["assigned_to"],
        $data["category_id"],
        $data["due_date"]
    )
) {
    $title = $data["title"];
    $description = $data["description"];
    $status = 1;
    $assigned_to = $data["assigned_to"];
    $category_id = $data["category_id"];
    $due_date = $data["due_date"];
    // file_put_contents("debug.log", print_r($due_date, true));
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, status, assigned_to, category_id, due_date) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiis", $title, $description, $status, $assigned_to, $category_id, $due_date);


    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Task added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
}
