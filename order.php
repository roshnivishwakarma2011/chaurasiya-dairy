<?php
// Include database connection
require_once '../db_config.php';

// Create database and table if not exists
try {
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS chaurasiya_dairy");

    // Use the created database
    $pdo->exec("USE chaurasiya_dairy");

    // Create the 'orders' table if it doesn't exist
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product VARCHAR(50),
            quantity INT,
            name VARCHAR(100),
            contact VARCHAR(15),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    $pdo->exec($createTableQuery);
} catch (PDOException $e) {
    die("Error creating database or table: " . $e->getMessage());
}

// Get the JSON data sent from the frontend
$data = json_decode(file_get_contents("php://input"));

// Extract the data
$product = $data->product;
$quantity = $data->quantity;
$name = $data->name;
$contact = $data->contact;

// Insert order into the 'orders' table
$query = "INSERT INTO orders (product, quantity, name, contact) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$product, $quantity, $name, $contact]);

// Send notification (example via email)
$to = "chaurasiyakishan1102@gmail.com";
$subject = "New Order from Chaurasiya Dairy";
$message = "Order Details:\nProduct: $product\nQuantity: $quantity\nCustomer: $name\nContact: $contact";
$headers = "From: no-reply@chaurasiya-dairy.com";

mail($to, $subject, $message, $headers);

// Return a success message to the frontend
echo json_encode(["message" => "Order placed successfully"]);
?>
