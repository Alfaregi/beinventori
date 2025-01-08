<?php  
$servername = "localhost";  
$username = "root"; // Adjust as needed  
$password = ""; // Adjust as needed  
$dbname = "inventori"; // Your database name  
  
// Create connection  
$conn = new mysqli($servername, $username, $password, $dbname);  
  
// Check connection  
if ($conn->connect_error) {  
    die("Connection failed: " . $conn->connect_error);  
}  
  
// Fetch product data  
$sql = "SELECT name, stock, image FROM products"; // Select only necessary fields  
$result = $conn->query($sql);  
  
$products = array();  
  
if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {  
        $products[] = $row;  
    }  
}  
  
// Return data in JSON format  
header('Content-Type: application/json');  
echo json_encode($products);  
  
$conn->close();  
?>  
