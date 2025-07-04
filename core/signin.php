<?php
session_start();
include "db.php";

header("Content-Type: application/json"); // Ensure JSON response

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $response["status"] = "error";
        $response["message"] = "All fields are required.";
        echo json_encode($response);
        exit();
    }


    $stmt = $conn->prepare("SELECT id, password, role, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $role = $row['role'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['id']; // Set session
            $_SESSION["role"] = $role;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['name'];
            $response["status"] = "success";
            $response["message"] = "Login successful";
            $response["role"] = $role;
        } else {
            $response["status"] = "error";
            $response["message"] = "Invalid credentials";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "User not found";
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response); // Send JSON response
}
