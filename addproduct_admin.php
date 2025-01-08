<?php    
  
error_reporting(E_ALL);  
ini_set('display_errors', 1);  
  
$servername = "localhost";    
$username = "root"; // Adjust with your database username    
$password = ""; // Adjust with your database password    
$dbname = "inventori"; // Your database name    
  
// Create connection    
$conn = new mysqli($servername, $username, $password, $dbname);    
  
// Check connection    
if ($conn->connect_error) {    
    die("Connection failed: " . $conn->connect_error);    
}    
  
// Ensure the uploads directory exists  
if (!is_dir('uploads')) {  
    mkdir('uploads', 0755, true); // Create the directory with appropriate permissions  
}  
  
// Get data from request    
$productName = $_POST['name'] ?? '';    
$productDetail = $_POST['description'] ?? '';    
$price = $_POST['price'] ?? '';    
$stock = $_POST['stock'] ?? '';    
$image = $_POST['image'] ?? ''; // Base64 image    
$idCategory = $_POST['id_category'] ?? '';    
  
// Validate input    
if (empty($productName) || empty($productDetail) || empty($price) || empty($stock) || empty($image)) {    
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);    
    exit;    
}    
  
// Decode the base64 image    
$imageData = str_replace('data:image/png;base64,', '', $image);    
$imageData = str_replace(' ', '+', $imageData);    
$imageName = uniqid() . '.png'; // Generate a unique name for the image    
$filePath = 'uploads/' . $imageName; // Path to save the image    
  
// Save the image to the server    
if (file_put_contents($filePath, base64_decode($imageData)) === false) {    
    echo json_encode(['status' => 'error', 'message' => 'Failed to save image.']);    
    exit;    
}    
  
// Prepare SQL statement    
$sql = "INSERT INTO products (name, description, price, stock, image, id_category) VALUES (?, ?, ?, ?, ?, ?)";    
$stmt = $conn->prepare($sql);    
$stmt->bind_param("ssssis", $productName, $productDetail, $price, $stock, $imageName, $idCategory);    
  
// Execute the statement    
if ($stmt->execute()) {    
    echo json_encode(['status' => 'success', 'message' => 'New product added successfully.']);    
} else {    
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);    
}    
  
// Close connections    
$stmt->close();    
$conn->close();    
?>    
