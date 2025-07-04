<?php
// header("Content-Type: application/json");
// include "db.php"; // Database connection




// $sql = "SELECT 
//             tasks.id, 
//             users.name AS username, 
//             tasks.title, 
//             tasks.description, 
//             task_categories.name AS category, 
//             tasks.status, 
//             tasks.due_date 
//         FROM tasks
//         JOIN users ON tasks.assigned_to = users.id
//         JOIN task_categories ON tasks.category_id = task_categories.id
//         ORDER BY tasks.id DESC";

// $result = $conn->query($sql);

// $tasks = [];
// while ($row = $result->fetch_assoc()) {
//     $tasks[] = $row;
// }

// echo json_encode($tasks);








header("Content-Type: application/json");
include "db.php";

// Get current page from query parameter
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$tasksPerPage = 10;
$offset = ($page - 1) * $tasksPerPage;

// Get total number of tasks for pagination
$countSql = "SELECT COUNT(*) as total FROM tasks";
$countResult = $conn->query($countSql);
$totalTasks = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalTasks / $tasksPerPage);

// Get tasks for current page
$sql = "SELECT 
            tasks.id, 
            users.name AS username, 
            tasks.title, 
            tasks.description, 
            task_categories.name AS category, 
            tasks.status, 
            tasks.due_date 
        FROM tasks
        JOIN users ON tasks.assigned_to = users.id
        JOIN task_categories ON tasks.category_id = task_categories.id
        ORDER BY tasks.id DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $tasksPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Return both tasks and pagination info
echo json_encode([
    'tasks' => $tasks,
    'pagination' => [
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'totalTasks' => $totalTasks
    ]
]);
