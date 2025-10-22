<?php
include('db_connect.php');

header('Content-Type: application/json');

try {
    $action = $_POST['action'] ?? $_GET['action'] ?? '';
    
    switch ($action) {
        case 'add':
            addCategory();
            break;
        case 'list':
            listCategories();
            break;
        case 'delete':
            deleteCategory();
            break;
        case 'update':
            updateCategory();
            break;
        default:
            listCategories();
    }
    
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

function addCategory() {
    global $conn;
    
    $name = trim($_POST['name']);
    $description = trim($_POST['description'] ?? '');
    
    if (empty($name)) {
        throw new Exception("Category name is required");
    }
    
    // Check if category already exists
    $check_stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $check_stmt->bind_param("s", $name);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        throw new Exception("Category already exists");
    }
    
    $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Category added successfully",
            "categoryId" => $conn->insert_id
        ]);
    } else {
        throw new Exception("Failed to add category");
    }
}

function listCategories() {
    global $conn;
    
    $result = $conn->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = [];
    
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            "id" => (int)$row['id'],
            "name" => $row['name'],
            "description" => $row['description'],
            "created_at" => $row['created_at']
        ];
    }
    
    echo json_encode([
        "status" => "success",
        "categories" => $categories
    ]);
}

function deleteCategory() {
    global $conn;
    
    $id = $_POST['id'];
    
    if (!is_numeric($id)) {
        throw new Exception("Invalid category ID");
    }
    
    // Check if category has products
    $check_stmt = $conn->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result()->fetch_assoc();
    
    if ($result['count'] > 0) {
        throw new Exception("Cannot delete category with existing products");
    }
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Category deleted successfully"
        ]);
    } else {
        throw new Exception("Failed to delete category");
    }
}

function updateCategory() {
    global $conn;
    
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description'] ?? '');
    
    if (!is_numeric($id)) {
        throw new Exception("Invalid category ID");
    }
    
    if (empty($name)) {
        throw new Exception("Category name is required");
    }
    
    // Check if category name already exists (excluding current category)
    $check_stmt = $conn->prepare("SELECT id FROM categories WHERE name = ? AND id != ?");
    $check_stmt->bind_param("si", $name, $id);
    $check_stmt->execute();
    
    if ($check_stmt->get_result()->num_rows > 0) {
        throw new Exception("Category name already exists");
    }
    
    $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Category updated successfully"
        ]);
    } else {
        throw new Exception("Failed to update category");
    }
}
?>
