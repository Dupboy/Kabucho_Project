<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $in_stock = $_POST['in_stock'];
    $buying_price = $_POST['buying_price'];
    $date_added = $_POST['date_added'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO products (product_name, category, in_stock, buying_price, date_added, expiry_date) 
            VALUES (:product_name, :category, :in_stock, :buying_price, :date_added, :expiry_date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':in_stock', $in_stock);
    $stmt->bindParam(':buying_price', $buying_price);
    $stmt->bindParam(':date_added', $date_added);
    $stmt->bindParam(':expiry_date', $expiry_date);
    if ($stmt->execute()) {
        echo "New product added successfully";
    } else {
        echo "Error adding product";
    }
}

// Fetch categories for the dropdown
$sql = "SELECT * FROM categories";
$categories = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Fetch products for the display table
$sql = "SELECT * FROM products";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Inventory Management System</h2>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="products.php" class="active">Products</a></li>
            <li><a href="sales_tracking.php">Sales</a></li>
            <li><a href="sales_reports.php">Sales Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Products</h1>
        <div class="add-product">
            <h2>Add New Product</h2>
            <form action="products.php" method="post">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">Select a Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['category_name']); ?>"><?= htmlspecialchars($category['category_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="in_stock">In Stock:</label>
                <input type="number" id="in_stock" name="in_stock" required>
                <label for="buying_price">Buying Price:</label>
                <input type="number" step="0.01" id="buying_price" name="buying_price" required>
                <label for="date_added">Date Added:</label>
                <input type="date" id="date_added" name="date_added" required>
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
        
        <div class="all-products">
            <h2>All Products</h2>
            <table class="table-products">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>In Stock</th>
                    <th>Buying Price</th>
                    <th>Date Added</th>
                    <th>Expiry Date</th>
                </tr>
                <?php
                $counter = 1;
                foreach ($products as $product) {
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$product['product_name']}</td>
                            <td>{$product['category']}</td>
                            <td>{$product['in_stock']}</td>
                            <td>{$product['buying_price']}</td>
                            <td>{$product['date_added']}</td>
                            <td>{$product['expiry_date']}</td>
                          </tr>";
                    $counter++;
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
