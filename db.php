<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "library_db";   // ✅ আপনার database নাম

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

// Optional: set charset to avoid unicode problems
mysqli_set_charset($conn, "utf8mb4");
?>