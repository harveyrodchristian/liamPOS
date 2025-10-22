<?php
include('db_connect.php');

$name = $_POST['name'];
$categoryId = $_POST['categoryId'];
$originalPrice = $_POST['originalPrice'];
$sellingPrice = $_POST['sellingPrice'];
$stock = $_POST['stock'];
$lowStock = $_POST['lowStock'];
$description = $_POST['description'] ?? '';

// Validate required fields
if (empty($name) || empty($categoryId) || !is_numeric($sellingPrice)) {
    echo "error";
    exit;
}

$stmt = $conn->prepare("INSERT INTO products (name, category_id, original_price, selling_price, stock, low_stock_threshold, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siddiis", $name, $categoryId, $originalPrice, $sellingPrice, $stock, $lowStock, $description);

if ($stmt->execute()) echo "success";
else echo "error";
?>
