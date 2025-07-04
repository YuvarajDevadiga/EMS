<?php
include 'db.php';

header("Content-Type: application/json"); // Set response type to JSON

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response["success"] = false;
        $response["message"] = "Email already registered. Please use a different email.";
    } else {
        // Insert user into database
        $sql_insert = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Registration successful! You can now log in.";
        } else {
            $response["success"] = false;
            $response["message"] = "Error: Could not complete registration.";
        }
    }

    $stmt->close();
    $conn->close();
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request.";
}

// Return JSON response
echo json_encode($response);
