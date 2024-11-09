<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity_sold'];
    $selling_price = $_POST['selling_price'];
    $sale_date = $_POST['sale_date'];

    $sql = "INSERT INTO sales (product_id, quantity_sold, selling_price, sale_date) 
            VALUES (:product_id, :quantity_sold, :selling_price, :sale_date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':quantity_sold', $quantity_sold);
    $stmt->bindParam(':selling_price', $selling_price);
    $stmt->bindParam(':sale_date', $sale_date);
    if ($stmt->execute()) {
        echo "New sale added successfully";
    } else {
        echo "Error adding sale: " . $stmt->errorInfo()[2];
    }
}

// Fetch products for the dropdown
$sql = "SELECT * FROM products";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Fetch sales for the display table
$sql = "SELECT s.sale_id, p.product_name, s.quantity_sold, s.selling_price, s.sale_date 
        FROM sales s 
        JOIN products p ON s.product_id = p.product_id";
$sales = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Tracking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Inventory Management System</h2>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="sales_tracking.php" class="active">Sales</a></li>
            <li><a href="sales_reports.php">Sales Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Sales Tracking</h1>
        <div class="add-sale">
            <h2>Add New Sale</h2>
            <form action="sales_tracking.php" method="post">
                <label for="product_id">Product:</label>
                <select id="product_id" name="product_id" required>
                    <option value="">Select a Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= htmlspecialchars($product['product_id']); ?>"><?= htmlspecialchars($product['product_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="quantity_sold">Quantity Sold:</label>
                <input type="number" id="quantity_sold" name="quantity_sold" required>
                <label for="selling_price">Selling Price:</label>
                <input type="number" step="0.01" id="selling_price" name="selling_price" required>
                <label for="sale_date">Sale Date:</label>
                <input type="date" id="sale_date" name="sale_date" required>
                <button type="submit">Add Sale</button>
            </form>
        </div>

        <div class="all-sales">
            <h2>All Sales</h2>
            <table class="table-sales">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Selling Price</th>
                    <th>Sale Date</th>
                </tr>
                <?php
                $counter = 1;
                foreach ($sales as $sale) {
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$sale['product_name']}</td>
                            <td>{$sale['quantity_sold']}</td>
                            <td>{$sale['selling_price']}</td>
                            <td>{$sale['sale_date']}</td>
                          </tr>";
                    $counter++;
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
