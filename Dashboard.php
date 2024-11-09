<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

// Fetch the number of categories
$categories_count = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Inventory Management System</h2>
        <ul>
            <li><a href="Dashboard.php" class="active">Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="sales_tracking.php">Sales</a></li>
            <li><a href="sales_reports.php">Sales Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <h1>Welcome to Inventory Management System</h1>
        <div class="dashboard-stats">
            <div class="card">
                <h3>Categories</h3>
                <p><?php echo $categories_count; ?></p>
            </div>
            <div class="card">
                <h3>Products</h3>
                <p>16</p> <!-- Replace with dynamic data -->
            </div>
            <div class="card">
                <h3>Sales</h3>
                <p>$9017.00</p> <!-- Replace with dynamic data -->
            </div>
        </div>
        
        <h2>Highest Selling Products</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Total Sold</th>
                <th>Total Quantity</th>
            </tr>
            <tr>
                <td>Small Bubble Cushioning Wrap</td>
                <td>4</td>
                <td>126</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
        
        <h2>Latest Sales</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Date</th>
                <th>Total Sale</th>
            </tr>
            <tr>
                <td>Disney Woody Action Figure</td>
                <td>2021-08-22</td>
                <td>$880.00</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
        
        <h2>Recently Added Products</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
            </tr>
            <tr>
                <td>IronWolf 10TB Internal HDD</td>
                <td>$295</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </div>
</body>
</html>
