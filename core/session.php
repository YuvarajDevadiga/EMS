<?php
session_start();
header("Content-Type: application/json");


// Debugging: Check what session data exists
error_log(print_r($_SESSION, true)); // Logs session data
// file_put_contents("debug.log", print_r($_SESSION, true));

if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    echo json_encode([

        "user_id" => $_SESSION['user_id'],
        "email" => $_SESSION['email'],
        "role" => $_SESSION['role'],


    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
}
