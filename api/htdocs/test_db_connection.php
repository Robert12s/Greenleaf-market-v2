<?php

require_once 'db.php';  // Adjust the path as needed

// Attempt to establish a connection
$conn = Database::getConnection();

// Check if connection is successful
if ($conn) {
    echo "Database connection successful!";
    
    // Optionally test querying the database
    $result = $conn->query("SELECT * FROM products LIMIT 1");
    
    if ($result && $result->num_rows > 0) {
        echo "Database query successful! Found products:";
        while ($row = $result->fetch_assoc()) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }
    } else {
        echo "No products found or query failed.";
    }
} else {
    echo "Database connection failed!";
}
?>
