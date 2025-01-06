<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "inventori"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data dari request
$productName = $_POST['name'];
$productDetail = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$image = $_POST['image']; // Asumsikan Anda mengirim URL atau path gambar
$idCategory = $_POST['id_category']; // Sesuaikan dengan kategori yang ada

// Menyimpan data ke database
$sql = "INSERT INTO products (name, description, price, stock, image, id_category) VALUES ('$productName', '$productDetail', '$price', '$stock', '$image', '$idCategory')";

if ($conn->query($sql) === TRUE) {
    echo "New product added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
