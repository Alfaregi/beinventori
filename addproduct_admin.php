<?php        
  
error_reporting(E_ALL);      
ini_set('display_errors', 1);      
  
$servername = "localhost";        
$username = "root"; // Sesuaikan dengan username database Anda        
$password = ""; // Sesuaikan dengan password database Anda        
$dbname = "inventori"; // Nama database Anda        
  
// Buat koneksi        
$conn = new mysqli($servername, $username, $password, $dbname);        
  
// Periksa koneksi        
if ($conn->connect_error) {        
    die("Connection failed: " . $conn->connect_error);        
}        
  
// Pastikan direktori uploads ada      
if (!is_dir('uploads')) {      
    mkdir('uploads', 0755, true); // Buat direktori dengan izin yang sesuai      
}      
  
// Ambil data dari permintaan        
$productName = $_POST['name'] ?? '';        
$productDetail = $_POST['description'] ?? '';        
$price = $_POST['price'] ?? '';        
$stock = $_POST['stock'] ?? '';        
$image = $_POST['image'] ?? ''; // Gambar dalam format Base64        
$idCategory = $_POST['id_category'] ?? '';        
  
// Validasi input        
if (empty($productName) || empty($productDetail) || empty($price) || empty($stock) || empty($image)) {        
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);        
    exit;        
}        
  
// Decode gambar Base64        
$imageData = str_replace('data:image/png;base64,', '', $image);        
$imageData = str_replace('data:image/jpeg;base64,', '', $imageData); // Tangani gambar JPEG    
$imageData = str_replace(' ', '+', $imageData);        
  
// Tentukan ekstensi file    
$fileExtension = strpos($image, 'data:image/png') === 0 ? 'png' : 'jpg'; // Default ke jpg jika bukan png    
$imageName = 'product_' . time() . '.' . $fileExtension; // Gunakan ekstensi yang ditentukan    
$filePath = 'uploads/' . $imageName; // Path untuk menyimpan gambar        
  
// Simpan gambar ke server        
if (file_put_contents($filePath, base64_decode($imageData)) === false) {        
    echo json_encode(['status' => 'error', 'message' => 'Failed to save image.']);        
    exit;        
}        
  
// Siapkan pernyataan SQL        
$sql = "INSERT INTO products (name, description, price, stock, image, id_category) VALUES (?, ?, ?, ?, ?, ?)";        
$stmt = $conn->prepare($sql);        
$stmt->bind_param("ssssis", $productName, $productDetail, $price, $stock, $imageName, $idCategory);        
  
// Eksekusi pernyataan        
if ($stmt->execute()) {        
    echo json_encode(['status' => 'success', 'message' => 'New product added successfully.']);        
} else {        
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);        
}        
  
// Tutup koneksi        
$stmt->close();        
$conn->close();        
?>        
