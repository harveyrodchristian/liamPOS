<?php
include('db_connect.php');

try {
    $result = $conn->query("
        SELECT 
            p.*,
            c.name as category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.name ASC
    ");
    
    if (!$result) {
        throw new Exception("Failed to fetch products");
    }
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            "id" => (int)$row['id'],
            "name" => $row['name'],
            "category" => $row['category_name'],
            "categoryId" => (int)$row['category_id'],
            "price" => (float)$row['selling_price'],
            "originalPrice" => (float)$row['original_price'],
            "stock" => (int)$row['stock'],
            "lowStockThreshold" => (int)$row['low_stock_threshold'],
            "description" => $row['description'],
            "isLowStock" => (int)$row['stock'] <= (int)$row['low_stock_threshold'],
            "isOutOfStock" => (int)$row['stock'] === 0
        ];
    }
    
    echo json_encode($products);
    
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
?>
