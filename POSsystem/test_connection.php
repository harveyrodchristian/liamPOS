<?php
// Test script to verify database connection and functionality
include('includes/db_connect.php');

echo "<h2>Database Connection Test</h2>";

// Test database connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
}

// Test if tables exist
$tables = ['categories', 'products', 'sales', 'sale_items'];
echo "<h3>Table Existence Check</h3>";

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✅ Table '$table' exists</p>";
    } else {
        echo "<p style='color: red;'>❌ Table '$table' does not exist</p>";
    }
}

// Test categories
echo "<h3>Categories Test</h3>";
$result = $conn->query("SELECT COUNT(*) as count FROM categories");
if ($result) {
    $count = $result->fetch_assoc()['count'];
    echo "<p>Categories count: $count</p>";
    
    if ($count > 0) {
        $result = $conn->query("SELECT * FROM categories LIMIT 5");
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} - {$row['description']}</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color: red;'>❌ Error querying categories: " . $conn->error . "</p>";
}

// Test products
echo "<h3>Products Test</h3>";
$result = $conn->query("SELECT COUNT(*) as count FROM products");
if ($result) {
    $count = $result->fetch_assoc()['count'];
    echo "<p>Products count: $count</p>";
    
    if ($count > 0) {
        $result = $conn->query("
            SELECT p.name, c.name as category, p.selling_price, p.stock 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LIMIT 5
        ");
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} ({$row['category']}) - ₱{$row['selling_price']} - Stock: {$row['stock']}</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color: red;'>❌ Error querying products: " . $conn->error . "</p>";
}

// Test sales
echo "<h3>Sales Test</h3>";
$result = $conn->query("SELECT COUNT(*) as count FROM sales");
if ($result) {
    $count = $result->fetch_assoc()['count'];
    echo "<p>Sales count: $count</p>";
} else {
    echo "<p style='color: red;'>❌ Error querying sales: " . $conn->error . "</p>";
}

echo "<h3>API Endpoints Test</h3>";
echo "<p><a href='api/get_statistics.php' target='_blank'>Test Statistics API</a></p>";
echo "<p><a href='api/get_sales.php' target='_blank'>Test Sales API</a></p>";
echo "<p><a href='api/get_top_products.php' target='_blank'>Test Top Products API</a></p>";
echo "<p><a href='includes/fetch_products.php' target='_blank'>Test Fetch Products API</a></p>";
echo "<p><a href='includes/manage_categories.php?action=list' target='_blank'>Test Categories API</a></p>";

echo "<h3>Main Pages</h3>";
echo "<p><a href='index.php' target='_blank'>POS System</a></p>";
echo "<p><a href='reports.php' target='_blank'>Reports Page</a></p>";

$conn->close();
?>
