<?php
$host = "localhost";
$dbname = "task_management";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    // echo "Database Connected Successfully"; 
}
