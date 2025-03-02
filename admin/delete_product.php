<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Product deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete the product.";
    }

    // Redirect back to the manage products page with a success or error message
    header("Location: manage_products.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid product ID.";
    header("Location: manage_products.php");
    exit();
}
