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
    http_response_code(500); // Internal Server Error    
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);    
    exit();    
}    
    
// Get data from request    
$productId = $_POST['id'] ?? '';    
$productName = $_POST['name'] ?? '';    
$productDetail = $_POST['description'] ?? '';    
$price = $_POST['price'] ?? '';    
$stock = $_POST['stock'] ?? '';    
$idCategory = $_POST['id_category'] ?? '';    
    
// Validate input    
if (empty($productId) || empty($productName) || empty($productDetail) || empty($price) || empty($stock)) {    
    http_response_code(400); // Bad Request    
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);    
    exit;    
}    
    
// Prepare SQL statement    
$sql = "UPDATE products SET name=?, description=?, price=?, stock=?, id_category=? WHERE id=?";    
$stmt = $conn->prepare($sql);    
$stmt->bind_param("ssissi", $productName, $productDetail, $price, $stock, $idCategory, $productId);    
    
// Execute the statement    
if ($stmt->execute()) {    
    echo json_encode(['status' => 'success', 'message' => 'Product updated successfully.']);    
} else {    
    http_response_code(500); // Internal Server Error    
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);    
}    
    
// Close connections    
$stmt->close();    
$conn->close();    
?>    
