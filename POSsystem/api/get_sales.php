<?php
include('../includes/db_connect.php');

header('Content-Type: application/json');

try {
    $from = $_GET['from'] ?? date('Y-m-d');
    $to = $_GET['to'] ?? date('Y-m-d');
    
    $stmt = $conn->prepare("
        SELECT 
            s.id,
            s.sale_date,
            s.total,
            s.amount_paid,
            s.change_amount,
            COUNT(si.id) as item_count
        FROM sales s
        LEFT JOIN sale_items si ON s.id = si.sale_id
        WHERE DATE(s.sale_date) BETWEEN ? AND ?
        GROUP BY s.id
        ORDER BY s.sale_date DESC
        LIMIT 50
    ");
    
    $stmt->bind_param("ss", $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $sales = [];
    while ($row = $result->fetch_assoc()) {
        $sales[] = [
            "id" => (int)$row['id'],
            "sale_date" => $row['sale_date'],
            "total" => (float)$row['total'],
            "amount_paid" => (float)$row['amount_paid'],
            "change_amount" => (float)$row['change_amount'],
            "item_count" => (int)$row['item_count']
        ];
    }
    
    echo json_encode($sales);
    
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}
?>
