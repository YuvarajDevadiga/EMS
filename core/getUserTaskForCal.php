<?php
// getAllTasks.php
// session_start();
// include "db.php";

// header("Content-Type: application/json");

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
//     echo json_encode([
//         "status" => "error",
//         "message" => "Unauthorized access"
//     ]);
//     exit();
// }

// $query = "
//     SELECT 
//         t.id, 
//         t.title, 
//         t.description, 
//         t.due_date, 
//         t.category_id, 
//         t.status,
//         t.assigned_to,
//         tc.name as category_name,
//         ts.status_name,
//         u.name as assigned_to_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     LEFT JOIN users u ON t.assigned_to = u.id
//     ORDER BY t.due_date ASC
// ";

// $result = $conn->query($query);
// $tasks = [];

// if ($result) {
//     while ($row = $result->fetch_assoc()) {
//         $tasks[] = $row;
//     }
// }

// echo json_encode([
//     "status" => "success",
//     "tasks" => $tasks
// ]);

// $conn->close();











session_start();
include "db.php";
header("Content-Type: application/json");

$response = [];

// Check user authentication
if (!isset($_SESSION['user_id'])) {
    $response["status"] = "error";
    $response["message"] = "User not logged in";
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get view type and filter parameters
$view_type = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
$category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

// Get month and year from request
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

if ($view_type === 'calendar') {
    // Base query for calendar view
    $query = "SELECT 
        t.id, 
        t.title, 
        t.description, 
        t.due_date,
        t.due_time, 
        t.category_id, 
        t.status,
        tc.name as category_name, 
        ts.status_name
    FROM tasks t
    LEFT JOIN task_categories tc ON t.category_id = tc.id
    LEFT JOIN task_status ts ON t.status = ts.id
    WHERE t.assigned_to = ? 
    AND MONTH(t.due_date) = ? 
    AND YEAR(t.due_date) = ?";

    $params = [$user_id, $month, $year];
    $types = 'iii';

    // Add category filter if provided
    if ($category_id) {
        $query .= " AND t.category_id = ?";
        $params[] = $category_id;
        $types .= 'i';
    }

    // Order by due date
    $query .= " ORDER BY t.due_date ASC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all tasks for the month
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    // Return response with all tasks for the month
    $response = [
        "status" => "success",
        "view_type" => "calendar",
        "tasks" => $tasks,
        "month" => $month,
        "year" => $year
    ];
} else {
    // Handle other view types if needed
    $response = [
        "status" => "error",
        "message" => "Invalid view type"
    ];
}

echo json_encode($response);
