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

// Retrieve POST data
$data = json_decode(file_get_contents("php://input"));

// Check if email and password are provided
if(isset($data->email) && isset($data->password)) {
    // Sanitize input to prevent SQL injection (you should use prepared statements for production)
    $email = mysqli_real_escape_string($conn, $data->email);
    $password = mysqli_real_escape_string($conn, $data->password);

    // Query to check if the provided credentials match any record in the database
    $query = "SELECT * FROM accounts WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        // Email found, check password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])) {
            // Login successful
            $response = array('success' => true);
        } else {
            // Incorrect password
            $response = array('success' => false, 'message' => 'Invalid email or password');
        }
    } else {
        // Email not found
        $response = array('success' => false, 'message' => 'Invalid email or password');
    }
} else {
    // Email or password not provided
    $response = array('success' => false, 'message' => 'Email or password not provided');
}

// Return JSON response
echo json_encode($response);

// Close database connection
$conn->close();
?>
