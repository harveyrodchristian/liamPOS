<?php
// Updated db_connect.php for includes directory
$host = "sql100.infinityfree.com"; // change if your InfinityFree host differs
$user = "if0_40230001"; // your InfinityFree DB username
$pass = "Asdfzxcvlkjmnb"; // replace with your InfinityFree MySQL password
$dbname = "if0_40230001_possystem"; // use your full database name (if0_40230001_liam_pos or similar)

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
