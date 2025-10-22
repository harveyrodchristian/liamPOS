<?php
include('../includes/db_connect.php');

header('Content-Type: application/json');

try {
    $stmt = $conn->query("
        SELECT 
            p.name,
            p.category,
            p.stock,
            COALESCE(SUM(si.quantity), 0) as quantity_sold,
            COALESCE(SUM(si.quantity * si.price), 0) as revenue
        FROM products p
        LEFT JOIN sale_items si ON p.id = si.product_id
        LEFT JOIN sales s ON si.sale_id = s.id
        WHERE s.sale_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) OR s.sale_date IS NULL
        GROUP BY p.id
        ORDER BY quantity_sold DESC, revenue DESC
        LIMIT 20
    ");
    
    $products = [];
    while ($row = $stmt->fetch_assoc()) {
        $products[] = [
            "name" => $row['name'],
            "category" => $row['category'],
            "stock" => (int)$row['stock'],
            "quantity_sold" => (int)$row['quantity_sold'],
            "revenue" => (float)$row['revenue']
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
