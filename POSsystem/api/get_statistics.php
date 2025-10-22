<?php
include('../includes/db_connect.php');

header('Content-Type: application/json');

try {
    $today = date('Y-m-d');
    
    // Get total sales count for today
    $sales_stmt = $conn->prepare("SELECT COUNT(*) as count FROM sales WHERE DATE(sale_date) = ?");
    $sales_stmt->bind_param("s", $today);
    $sales_stmt->execute();
    $totalSales = $sales_stmt->get_result()->fetch_assoc()['count'];
    
    // Get total revenue for today
    $revenue_stmt = $conn->prepare("SELECT COALESCE(SUM(total), 0) as total FROM sales WHERE DATE(sale_date) = ?");
    $revenue_stmt->bind_param("s", $today);
    $revenue_stmt->execute();
    $totalRevenue = $revenue_stmt->get_result()->fetch_assoc()['total'];
    
    // Get total products count
    $products_stmt = $conn->query("SELECT COUNT(*) as count FROM products");
    $totalProducts = $products_stmt->fetch_assoc()['count'];
    
    // Get low stock count
    $lowStock_stmt = $conn->query("SELECT COUNT(*) as count FROM products WHERE stock <= low_stock_threshold");
    $lowStockCount = $lowStock_stmt->fetch_assoc()['count'];
    
    echo json_encode([
        "status" => "success",
        "stats" => [
            "totalSales" => (int)$totalSales,
            "totalRevenue" => (float)$totalRevenue,
            "totalProducts" => (int)$totalProducts,
            "lowStockCount" => (int)$lowStockCount
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
