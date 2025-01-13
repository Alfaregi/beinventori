<?php  
error_reporting(E_ALL);  
ini_set('display_errors', 1);  
  
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
  
// Get the username and password from the request  
$user = $_POST['username'];  
$pass = $_POST['password'];  
  
// Prepare and bind  
$stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");  
$stmt->bind_param("s", $user);  
$stmt->execute();  
$stmt->store_result();  
  
if ($stmt->num_rows > 0) {  
    $stmt->bind_result($hashedPassword, $role);  
    $stmt->fetch();  
      
    // Verify the password  
    if (password_verify($pass, $hashedPassword)) {  
        echo json_encode(['status' => 'success', 'role' => $role]);  
    } else {  
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);  
    }  
} else {  
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);  
}  
  
$stmt->close();  
$conn->close();  
?>  
