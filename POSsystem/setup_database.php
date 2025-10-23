<?php
// Database setup script
include('includes/db_connect.php');

echo "<h2>Database Setup</h2>";

if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
}

echo "<p style='color: green;'>✅ Database connection successful!</p>";

// Read and execute the database schema
$schema = file_get_contents('database_schema.sql');
if ($schema === false) {
    echo "<p style='color: red;'>❌ Could not read database_schema.sql</p>";
    exit;
}

// Split the schema into individual statements
$statements = array_filter(array_map('trim', explode(';', $schema)));

echo "<h3>Executing Database Schema</h3>";

$success_count = 0;
$error_count = 0;

foreach ($statements as $statement) {
    if (empty($statement)) continue;
    
    if ($conn->query($statement)) {
        $success_count++;
        echo "<p style='color: green;'>✅ Executed: " . substr($statement, 0, 50) . "...</p>";
    } else {
        $error_count++;
        echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
        echo "<p style='color: red;'>Statement: " . substr($statement, 0, 100) . "...</p>";
    }
}

echo "<h3>Setup Summary</h3>";
echo "<p>✅ Successful statements: $success_count</p>";
echo "<p>❌ Failed statements: $error_count</p>";

if ($error_count == 0) {
    echo "<p style='color: green; font-weight: bold;'>🎉 Database setup completed successfully!</p>";
    echo "<p><a href='test_connection.php'>Test the connection</a></p>";
    echo "<p><a href='index.php'>Go to POS System</a></p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>⚠️ Some errors occurred during setup. Please check the errors above.</p>";
}

$conn->close();
?>
