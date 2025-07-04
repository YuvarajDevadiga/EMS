<?php
// session_start();
// include "db.php";

// header("Content-Type: application/json");

// $response = [];

// if (!isset($_SESSION['user_id'])) {
//     $response["status"] = "error";
//     $response["message"] = "User not logged in";
//     echo json_encode($response);
//     exit();
// }

// $user_id = $_SESSION['user_id']; // Get logged-in user ID

// // Fetch tasks assigned to the user
// $stmt = $conn->prepare("SELECT id, title, description, due_date, category_id, status FROM tasks WHERE assigned_to = ?");
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();

// $tasks = [];
// while ($row = $result->fetch_assoc()) {
//     $tasks[] = $row;
// }

// if ($tasks) {
//     // i want to  fetch the current status of the task and also based on the category_id i want the name of the
//     foreach ($tasks as $key => $task) {
//         // Fetch Category Name
//         $stmt = $conn->prepare("SELECT name FROM task_categories WHERE id = ?");
//         $stmt->bind_param("i", $task['category_id']);
//         $stmt->execute();
//         $category_result = $stmt->get_result();
//         $tasks[$key]['category_name'] = $category_result->fetch_assoc()['name'] ?? "Unknown";

//         // Fetch Status Name
//         $stmt = $conn->prepare("SELECT status_name FROM task_status WHERE id = ?");
//         $stmt->bind_param("i", $task['status']);
//         $stmt->execute();
//         $status_result = $stmt->get_result();
//         $tasks[$key]['status_name'] = $status_result->fetch_assoc()['status_name'] ?? "Unknown";
//     }
// }

// $stmt->close();
// $conn->close();

// echo json_encode(["status" => "success", "tasks" => $tasks]);







// getLoggedInUserTask.php

// session_start();
// include "db.php";

// header("Content-Type: application/json");

// $response = [];

// if (!isset($_SESSION['user_id'])) {
//     $response["status"] = "error";
//     $response["message"] = "User not logged in";
//     echo json_encode($response);
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// // Get page number and items per page from request
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $items_per_page = 10;
// $offset = ($page - 1) * $items_per_page;

// // Get total count of tasks for pagination
// $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE assigned_to = ?");
// $count_stmt->bind_param("i", $user_id);
// $count_stmt->execute();
// $total_result = $count_stmt->get_result();
// $total_tasks = $total_result->fetch_assoc()['total'];
// $total_pages = ceil($total_tasks / $items_per_page);

// // Fetch paginated tasks
// $stmt = $conn->prepare("
//     SELECT t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//            tc.name as category_name, ts.status_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     WHERE t.assigned_to = ?
//     ORDER BY t.due_date ASC
//     LIMIT ? OFFSET ?
// ");

// $stmt->bind_param("iii", $user_id, $items_per_page, $offset);
// $stmt->execute();
// $result = $stmt->get_result();

// $tasks = [];
// while ($row = $result->fetch_assoc()) {
//     $tasks[] = $row;
// }

// $stmt->close();
// $conn->close();

// echo json_encode([
//     "status" => "success",
//     "tasks" => $tasks,
//     "pagination" => [
//         "current_page" => $page,
//         "total_pages" => $total_pages,
//         "total_tasks" => $total_tasks,
//         "items_per_page" => $items_per_page
//     ]
// ]);







// session_start();
// include "db.php";
// header("Content-Type: application/json");

// $response = [];

// // Check user authentication
// if (!isset($_SESSION['user_id'])) {
//     $response["status"] = "error";
//     $response["message"] = "User not logged in";
//     echo json_encode($response);
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// // Get view type from request (dashboard or calendar)
// $view_type = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// // Get page number and items per page from request (for dashboard view)
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $items_per_page = 10;
// $offset = ($page - 1) * $items_per_page;

// // Base query for both views
// $base_query = "
//     SELECT t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//            tc.name as category_name, ts.status_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     WHERE t.assigned_to = ?
// ";

// if ($view_type === 'dashboard') {
//     // Get total count of tasks for pagination
//     $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE assigned_to = ?");
//     $count_stmt->bind_param("i", $user_id);
//     $count_stmt->execute();
//     $total_result = $count_stmt->get_result();
//     $total_tasks = $total_result->fetch_assoc()['total'];
//     $total_pages = ceil($total_tasks / $items_per_page);

//     // Add pagination for dashboard view
//     $query = $base_query . " ORDER BY t.due_date ASC LIMIT ? OFFSET ?";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("iii", $user_id, $items_per_page, $offset);
// } else {
//     // Calendar view - fetch all tasks without pagination
//     $query = $base_query . " ORDER BY t.due_date ASC";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("i", $user_id);
// }

// $stmt->execute();
// $result = $stmt->get_result();

// $tasks = [];
// while ($row = $result->fetch_assoc()) {
//     $tasks[] = $row;
// }

// $stmt->close();
// $conn->close();

// // Prepare response based on view type
// if ($view_type === 'dashboard') {
//     $response = [
//         "status" => "success",
//         "view_type" => "dashboard",
//         "tasks" => $tasks,
//         "pagination" => [
//             "current_page" => $page,
//             "total_pages" => $total_pages,
//             "total_tasks" => $total_tasks,
//             "items_per_page" => $items_per_page
//         ]
//     ];
// } else {
//     $response = [
//         "status" => "success",
//         "view_type" => "calendar",
//         "tasks" => $tasks
//     ];
// }

// echo json_encode($response);












// session_start();
// include "db.php";
// header("Content-Type: application/json");

// $response = [];

// // Check user authentication
// if (!isset($_SESSION['user_id'])) {
//     $response["status"] = "error";
//     $response["message"] = "User not logged in";
//     echo json_encode($response);
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// // Get view type from request
// $view_type = isset($_GET['view']) ? $_GET['view'] : 'dashboard';

// // Get filter parameters
// $category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

// // Month/year specific loading
// $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
// $year = isset($_GET['year']) ? (int)$_GET['year'] : null;

// // Date-based filtering parameters
// $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
// $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
// $specific_date = isset($_GET['date']) ? $_GET['date'] : null;

// // For dashboard pagination
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $items_per_page = 10;
// $offset = ($page - 1) * $items_per_page;

// // Maximum results to return to prevent memory issues
// $max_results = 500;

// // Build query differently based on view type for optimal performance
// if ($view_type === 'calendar') {
//     // For calendar view, fetch chunks of data based on month/year if provided
//     if ($month && $year) {
//         // Month-specific query optimization
//         $query = "SELECT 
//             t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//             tc.name as category_name, ts.status_name
//         FROM tasks t
//         LEFT JOIN task_categories tc ON t.category_id = tc.id
//         LEFT JOIN task_status ts ON t.status = ts.id
//         WHERE t.assigned_to = ? AND MONTH(t.due_date) = ? AND YEAR(t.due_date) = ?";

//         $params = [$user_id, $month, $year];
//         $types = 'iii';

//         // Add category filter if provided
//         if ($category_id) {
//             $query .= " AND t.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY t.due_date ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param($types, ...$params);
//     } else if ($start_date && $end_date) {
//         // Date range query using BETWEEN
//         $query = "SELECT 
//             t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//             tc.name as category_name, ts.status_name
//         FROM tasks t
//         LEFT JOIN task_categories tc ON t.category_id = tc.id
//         LEFT JOIN task_status ts ON t.status = ts.id
//         WHERE t.assigned_to = ? AND t.due_date BETWEEN ? AND ?";

//         $params = [$user_id, $start_date, $end_date];
//         $types = 'iss';

//         // Add category filter if provided
//         if ($category_id) {
//             $query .= " AND t.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY t.due_date ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param($types, ...$params);
//     } else {
//         // Fallback to a more general query with hard limit
//         $query = "SELECT 
//             t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//             tc.name as category_name, ts.status_name
//         FROM tasks t
//         LEFT JOIN task_categories tc ON t.category_id = tc.id
//         LEFT JOIN task_status ts ON t.status = ts.id
//         WHERE t.assigned_to = ?";

//         $params = [$user_id];
//         $types = 'i';

//         // Add category filter if provided
//         if ($category_id) {
//             $query .= " AND t.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY t.due_date ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param($types, ...$params);
//     }
// } else if ($view_type === 'day') {
//     // Day-specific query for modal view
//     $query = "SELECT 
//         t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//         tc.name as category_name, ts.status_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     WHERE t.assigned_to = ? AND DATE(t.due_date) = ?";

//     $params = [$user_id, $specific_date];
//     $types = 'is';

//     // Add category filter if provided
//     if ($category_id) {
//         $query .= " AND t.category_id = ?";
//         $params[] = $category_id;
//         $types .= 'i';
//     }

//     $query .= " ORDER BY t.due_date ASC";

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param($types, ...$params);
// } else {
//     // Dashboard view with pagination
//     $query = "SELECT 
//         t.id, t.title, t.description, t.due_date, t.category_id, t.status,
//         tc.name as category_name, ts.status_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     WHERE t.assigned_to = ?";

//     $params = [$user_id];
//     $types = 'i';

//     // Add category filter if provided
//     if ($category_id) {
//         $query .= " AND t.category_id = ?";
//         $params[] = $category_id;
//         $types .= 'i';
//     }

//     // Count for pagination
//     $count_query = "SELECT COUNT(*) as total FROM tasks t WHERE t.assigned_to = ?";
//     if ($category_id) {
//         $count_query .= " AND t.category_id = ?";
//     }

//     $count_stmt = $conn->prepare($count_query);
//     $count_stmt->bind_param($types, ...$params);
//     $count_stmt->execute();
//     $total_result = $count_stmt->get_result();
//     $total_tasks = $total_result->fetch_assoc()['total'];
//     $total_pages = ceil($total_tasks / $items_per_page);

//     // Add pagination
//     $query .= " ORDER BY t.due_date ASC LIMIT ? OFFSET ?";
//     $params[] = $items_per_page;
//     $params[] = $offset;
//     $types .= 'ii';

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param($types, ...$params);
// }

// // Execute the prepared statement
// $stmt->execute();
// $result = $stmt->get_result();

// // Fetch results
// $tasks = [];
// while ($row = $result->fetch_assoc()) {
//     $tasks[] = $row;
// }

// // Return appropriate response based on view type
// if ($view_type === 'dashboard') {
//     $response = [
//         "status" => "success",
//         "view_type" => "dashboard",
//         "tasks" => $tasks,
//         "pagination" => [
//             "current_page" => $page,
//             "total_pages" => $total_pages,
//             "total_tasks" => $total_tasks,
//             "items_per_page" => $items_per_page
//         ]
//     ];
// } else {
//     $response = [
//         "status" => "success",
//         "view_type" => $view_type,
//         "tasks" => $tasks,
//         "count" => count($tasks),
//         "max_limit" => $max_results
//     ];
// }

// echo json_encode($response);







// session_start();
// include "db.php";
// header("Content-Type: application/json");

// $response = [];

// // Check user authentication
// if (!isset($_SESSION['user_id'])) {
//     $response["status"] = "error";
//     $response["message"] = "User not logged in";
//     echo json_encode($response);
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// // Get view type and filter parameters
// $view_type = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
// $category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;

// // Get month and year from request
// $month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
// $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// if ($view_type === 'calendar') {
//     // Base query for calendar view
//     $query = "SELECT 
//         t.id, 
//         t.title, 
//         t.description, 
//         t.due_date,
//         t.due_time, 
//         t.category_id, 
//         t.status,
//         tc.name as category_name, 
//         ts.status_name
//     FROM tasks t
//     LEFT JOIN task_categories tc ON t.category_id = tc.id
//     LEFT JOIN task_status ts ON t.status = ts.id
//     WHERE t.assigned_to = ? 
//     AND MONTH(t.due_date) = ? 
//     AND YEAR(t.due_date) = ?";

//     $params = [$user_id, $month, $year];
//     $types = 'iii';

//     // Add category filter if provided
//     if ($category_id) {
//         $query .= " AND t.category_id = ?";
//         $params[] = $category_id;
//         $types .= 'i';
//     }

//     // Order by due date
//     $query .= " ORDER BY t.due_date ASC";

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param($types, ...$params);

//     // Execute the query
//     $stmt->execute();
//     $result = $stmt->get_result();

//     // Fetch all tasks for the month
//     $tasks = [];
//     while ($row = $result->fetch_assoc()) {
//         $tasks[] = $row;
//     }

//     // Return response with all tasks for the month
//     $response = [
//         "status" => "success",
//         "view_type" => "calendar",
//         "tasks" => $tasks,
//         "month" => $month,
//         "year" => $year
//     ];
// } else {
//     // Handle other view types if needed
//     $response = [
//         "status" => "error",
//         "message" => "Invalid view type"
//     ];
// }

// echo json_encode($response);








session_start();
include "db.php";

header("Content-Type: application/json");

$response = [];

if (!isset($_SESSION['user_id'])) {
    $response["status"] = "error";
    $response["message"] = "User not logged in";
    echo json_encode($response);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get page number and items per page from request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

// Get total count of tasks for pagination
$count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE assigned_to = ?");
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$total_result = $count_stmt->get_result();
$total_tasks = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_tasks / $items_per_page);

// Fetch paginated tasks
$stmt = $conn->prepare("
    SELECT t.id, t.title, t.description, t.due_date, t.category_id, t.status,
           tc.name as category_name, ts.status_name
    FROM tasks t
    LEFT JOIN task_categories tc ON t.category_id = tc.id
    LEFT JOIN task_status ts ON t.status = ts.id
    WHERE t.assigned_to = ?
    ORDER BY t.due_date ASC
    LIMIT ? OFFSET ?
");

$stmt->bind_param("iii", $user_id, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode([
    "status" => "success",
    "tasks" => $tasks,
    "pagination" => [
        "current_page" => $page,
        "total_pages" => $total_pages,
        "total_tasks" => $total_tasks,
        "items_per_page" => $items_per_page
    ]
]);
