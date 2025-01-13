<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "inventori"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product data
$sql = "SELECT id, name, stock, price, CONCAT('http://localhost/beinventori/uploads/', image) as image FROM products";  
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Return data in JSON format
header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>
