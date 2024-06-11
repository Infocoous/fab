<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Set Content-Type header to JSON
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_accounts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $response = ['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error];
    echo json_encode($response);
    exit();
}

// Get data from the request
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Validate email and password
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response = ['success' => false, 'message' => 'Invalid email format'];
    echo json_encode($response);
    exit();
}
if (empty($password)) { 
    $response = ['success' => false, 'message' => 'Password cannot be empty'];
    echo json_encode($response);
    exit();
}

// Hash the password


// Insert data into the database
$sql = "INSERT INTO accounts (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    $response = ['success' => true, 'message' => 'Account created successfully'];
    echo json_encode($response);

} else {
    $response = ['success' => false, 'message' => 'Error: ' . $stmt->error];
    echo json_encode($response);

}


// Close statement and connection
$stmt->close();
$conn->close();
?>
