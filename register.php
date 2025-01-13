<?php  
$servername = "localhost"; // Your database server  
$username = "root"; // Your database username  
$password = ""; // Your database password  
$dbname = "inventori"; // Your database name  
  
// Create connection  
$conn = new mysqli($servername, $username, $password, $dbname);  
  
// Check connection  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  
  
// Get the data from the request  
$name = $_POST['name'];  
$user = $_POST['username'];  
$pass = $_POST['password'];  
  
// Check if the username already exists  
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");  
$stmt->bind_param("s", $user);  
$stmt->execute();  
$stmt->store_result();  
  
if ($stmt->num_rows > 0) {  
    echo json_encode(['status' => 'error', 'message' => 'Username already exists']);  
} else {  
    // Insert the new user into the database  
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, 'user', NOW())");  
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT); // Hash the password for security  
    $stmt->bind_param("ss", $user, $hashedPassword);  
  
    if ($stmt->execute()) {  
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);  
    } else {  
        echo json_encode(['status' => 'error', 'message' => 'Registration failed']);  
    }  
}  
  
$stmt->close();  
$conn->close();  
?>  
