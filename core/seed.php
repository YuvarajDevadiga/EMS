<?php
// include 'db.php'; // Ensure you have a database connection

// $insertQuery = "INSERT INTO tasks (title, description, assigned_to, due_date, status, category_id) VALUES (?, ?, ?, ?, ?, ?)";
// $stmt = $conn->prepare($insertQuery);

// // Generate 20,000 tasks
// for ($i = 1; $i <= 20000; $i++) {
//     $title = "Task " . $i;
//     $description = "Sample task description";
//     $assigned_to = rand(2, 3); //user IDs exist from 1 to 3
//     $due_date = date('Y-m-d', strtotime("+" . rand(1, 30) . " days"));
//     $status = 1;
//     $category_id = rand(1, 5); // you have 5 categories

//     $stmt->bind_param("ssisii", $title, $description, $assigned_to, $due_date, $status, $category_id);
//     $stmt->execute();
// }

// echo "20,000 tasks inserted successfully!";
// $stmt->close();
// $conn->close();




include 'db.php'; // Ensure you have a database connection

$insertQuery = "INSERT INTO tasks (title, description, assigned_to, due_date, status, category_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);

// Specific user IDs to choose from
$userIds = [2, 3, 19, 23, 24];

// Function to generate random date
function getRandomDate()
{
    $year = 2025; // Current year
    $month = rand(1, 12); // Random month from 1 to 12
    $day = rand(1, 28); // Using 28 to avoid invalid dates in February

    // Format the date components with leading zeros
    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    $day = str_pad($day, 2, '0', STR_PAD_LEFT);

    return "$year-$month-$day";
}

// Generate 20,000 tasks
for ($i = 1; $i <= 20000; $i++) {
    $title = "Task " . $i;
    $description = "Sample task description";
    $assigned_to = $userIds[array_rand($userIds)]; // Randomly select from specific user IDs
    $due_date = getRandomDate();
    $status = 1;
    $category_id = rand(1, 5); // you have 5 categories

    $stmt->bind_param("ssisii", $title, $description, $assigned_to, $due_date, $status, $category_id);
    $stmt->execute();
}

echo "20,000 tasks inserted successfully!";
$stmt->close();
$conn->close();
