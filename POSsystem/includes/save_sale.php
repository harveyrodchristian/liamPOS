<?php
include('db_connect.php');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data) {
        throw new Exception("Invalid JSON data");
    }

    $total = $data['total'];
    $amountPaid = $data['amountPaid'];
    $change = $data['change'];
    $items = $data['items'];

    // Validate required fields
    if (!isset($total) || !isset($amountPaid) || !isset($change) || !isset($items)) {
        throw new Exception("Missing required fields");
    }

    // Start transaction
    $conn->begin_transaction();

    // Insert sale record
    $stmt = $conn->prepare("INSERT INTO sales (total, amount_paid, change_amount, sale_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ddd", $total, $amountPaid, $change);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to insert sale record");
    }
    
    $sale_id = $conn->insert_id;

    // Insert sale items and update stock
    foreach ($items as $item) {
        $id = $item['id'];
        $qty = $item['quantity'];
        $price = $item['price'];
        
        // Insert sale item
        $item_stmt = $conn->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $item_stmt->bind_param("iiid", $sale_id, $id, $qty, $price);
        
        if (!$item_stmt->execute()) {
            throw new Exception("Failed to insert sale item");
        }
        
        // Update product stock
        $stock_stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stock_stmt->bind_param("ii", $qty, $id);
        
        if (!$stock_stmt->execute()) {
            throw new Exception("Failed to update product stock");
        }
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        "status" => "success",
        "saleId" => $sale_id,
        "message" => "Sale completed successfully"
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
