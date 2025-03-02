<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Simplified, should handle file uploads properly

    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, description = :description, image = :image WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'image' => $image,
        'id' => $id
    ]);

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>

<body>


    <div class="container">
        <h2>Edit Product</h2>
        <form method="POST">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']); ?>" id="price" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($product['description']); ?></textarea>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image" value="<?= htmlspecialchars($product['image']); ?>" required>

            <button type="submit">Edit Product</button>
        </form>
        <div class="back-link">
            <a href="manage_products.php">Back to Manage Products</a>
        </div>
    </div>

</body>

</html>