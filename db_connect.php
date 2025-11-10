<?php
// ---------- Database Connection ----------

// Server details
$servername = "localhost";   // because it's your local XAMPP server
$username   = "root";        // default XAMPP user
$password   = "";            // blank by default (no password)
$database   = "firewall_db"; // your database name from Step 2

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Optional: uncomment this line temporarily to verify connection
// echo "✅ Database connected successfully!";
?>
