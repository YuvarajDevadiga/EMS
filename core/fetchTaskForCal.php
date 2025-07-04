<?php
// header("Content-Type: application/json");
// include "db.php";

// // Get view type and date parameters
// $view_type = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $tasksPerPage = 10;
// $offset = ($page - 1) * $tasksPerPage;

// // Get filter parameters
// $category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? (int)$_GET['category_id'] : null;
// $user_id = isset($_GET['user_id']) && !empty($_GET['user_id']) ? (int)$_GET['user_id'] : null;

// // Month/year specific loading
// $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
// $year = isset($_GET['year']) ? (int)$_GET['year'] : null;

// // Date-based filtering parameters
// $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
// $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
// $specific_date = isset($_GET['date']) ? $_GET['date'] : null;

// // Maximum results to return to prevent memory issues
// $max_results = 500;

// // Base SELECT query fields used across all view types
// $base_select = "SELECT 
//     tasks.id,
//     users.name AS username,
//     tasks.title,
//     tasks.description,
//     tasks.category_id,
//     tasks.assigned_to,
//     task_categories.name AS category,
//     tasks.status,
//     tasks.due_date,
//     tasks.due_time,
//     task_status.status_name AS status_name";

// // Build query differently based on view type for optimal performance
// if ($view_type === 'calendar') {
//     // For calendar view, fetch chunks of data based on month/year if provided
//     if ($month && $year) {
//         // Month-specific query optimization
//         $query = $base_select . "
//         FROM tasks 
//         JOIN users ON tasks.assigned_to = users.id 
//         JOIN task_categories ON tasks.category_id = task_categories.id 
//         JOIN task_status ON tasks.status = task_status.id
//         WHERE MONTH(tasks.due_date) = ? AND YEAR(tasks.due_date) = ?";

//         $params = [$month, $year];
//         $types = 'ii';

//         // Add filters if provided
//         if ($category_id) {
//             $query .= " AND tasks.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         if ($user_id) {
//             $query .= " AND tasks.assigned_to = ?";
//             $params[] = $user_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY tasks.due_date ASC, tasks.due_time ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param($types, ...$params);
//     } else if ($start_date && $end_date) {
//         // Date range query using BETWEEN
//         $query = $base_select . "
//         FROM tasks 
//         JOIN users ON tasks.assigned_to = users.id 
//         JOIN task_categories ON tasks.category_id = task_categories.id 
//         JOIN task_status ON tasks.status = task_status.id
//         WHERE tasks.due_date BETWEEN ? AND ?";

//         $params = [$start_date, $end_date];
//         $types = 'ss';

//         // Add filters if provided
//         if ($category_id) {
//             $query .= " AND tasks.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         if ($user_id) {
//             $query .= " AND tasks.assigned_to = ?";
//             $params[] = $user_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY tasks.due_date ASC, tasks.due_time ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         $stmt->bind_param($types, ...$params);
//     } else {
//         // Fallback to a more general query with hard limit
//         $query = $base_select . "
//         FROM tasks 
//         JOIN users ON tasks.assigned_to = users.id 
//         JOIN task_categories ON tasks.category_id = task_categories.id 
//         JOIN task_status ON tasks.status = task_status.id";

//         $params = [];
//         $types = '';

//         // Add filters if provided
//         if ($category_id) {
//             $query .= ($params ? " AND" : " WHERE") . " tasks.category_id = ?";
//             $params[] = $category_id;
//             $types .= 'i';
//         }

//         if ($user_id) {
//             $query .= ($params ? " AND" : " WHERE") . " tasks.assigned_to = ?";
//             $params[] = $user_id;
//             $types .= 'i';
//         }

//         // Add limit to prevent loading too many tasks
//         $query .= " ORDER BY tasks.due_date ASC, tasks.due_time ASC LIMIT ?";
//         $params[] = $max_results;
//         $types .= 'i';

//         $stmt = $conn->prepare($query);
//         if (!empty($params)) {
//             $stmt->bind_param($types, ...$params);
//         }
//     }
// } else if ($view_type === 'day') {
//     // Day-specific query for modal view
//     $query = $base_select . "
//     FROM tasks 
//     JOIN users ON tasks.assigned_to = users.id 
//     JOIN task_categories ON tasks.category_id = task_categories.id 
//     JOIN task_status ON tasks.status = task_status.id
//     WHERE DATE(tasks.due_date) = ?";

//     $params = [$specific_date];
//     $types = 's';

//     // Add filters if provided
//     if ($category_id) {
//         $query .= " AND tasks.category_id = ?";
//         $params[] = $category_id;
//         $types .= 'i';
//     }

//     if ($user_id) {
//         $query .= " AND tasks.assigned_to = ?";
//         $params[] = $user_id;
//         $types .= 'i';
//     }

//     $query .= " ORDER BY tasks.due_time ASC";

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param($types, ...$params);
// } else {
//     // Dashboard view with pagination
//     $query = $base_select . "
//     FROM tasks 
//     JOIN users ON tasks.assigned_to = users.id 
//     JOIN task_categories ON tasks.category_id = task_categories.id 
//     JOIN task_status ON tasks.status = task_status.id";

//     $params = [];
//     $types = '';

//     // Add filters if provided
//     if ($category_id) {
//         $query .= ($params ? " AND" : " WHERE") . " tasks.category_id = ?";
//         $params[] = $category_id;
//         $types .= 'i';
//     }

//     if ($user_id) {
//         $query .= ($params ? " AND" : " WHERE") . " tasks.assigned_to = ?";
//         $params[] = $user_id;
//         $types .= 'i';
//     }

//     // Count for pagination
//     $countQuery = str_replace($base_select, "SELECT COUNT(*) as total", $query);

//     $countStmt = $conn->prepare($countQuery);
//     if (!empty($params)) {
//         $countStmt->bind_param($types, ...$params);
//     }
//     $countStmt->execute();
//     $totalResult = $countStmt->get_result();
//     $totalTasks = $totalResult->fetch_assoc()['total'];
//     $totalPages = ceil($totalTasks / $tasksPerPage);

//     // Add pagination
//     $query .= " ORDER BY tasks.due_date ASC, tasks.due_time ASC LIMIT ? OFFSET ?";
//     $params[] = $tasksPerPage;
//     $params[] = $offset;
//     $types .= 'ii';

//     $stmt = $conn->prepare($query);
//     if (!empty($params)) {
//         $stmt->bind_param($types, ...$params);
//     }
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
//     echo json_encode([
//         "status" => "success",
//         'view_type' => 'dashboard',
//         'tasks' => $tasks,
//         'pagination' => [
//             'currentPage' => $page,
//             'totalPages' => $totalPages,
//             'totalTasks' => $totalTasks
//         ]
//     ]);
// } else {
//     echo json_encode([
//         "status" => "success",
//         'view_type' => $view_type,
//         'tasks' => $tasks,
//         'count' => count($tasks),
//         'max_limit' => $max_results
//     ]);
// }













header("Content-Type: application/json");
include "db.php";

// Get month and year parameters
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;

// Base query to get all necessary task information
$query = "SELECT 
    tasks.id,
    users.name AS username,
    tasks.title,
    tasks.description,
    tasks.category_id,
    tasks.assigned_to,
    task_categories.name AS category,
    tasks.status,
    tasks.due_date,
    tasks.due_time,
    task_status.status_name AS status_name
    FROM tasks 
    JOIN users ON tasks.assigned_to = users.id 
    JOIN task_categories ON tasks.category_id = task_categories.id 
    JOIN task_status ON tasks.status = task_status.id
    WHERE MONTH(tasks.due_date) = ? AND YEAR(tasks.due_date) = ?
    ORDER BY tasks.due_date ASC, tasks.due_time ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $month, $year);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all tasks for the month
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Return the response
echo json_encode([
    "status" => "success",
    "tasks" => $tasks
]);
