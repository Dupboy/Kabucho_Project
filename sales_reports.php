<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

$report = [];
$start_date = '';
$end_date = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql = "SELECT p.product_name, p.buying_price, s.selling_price, SUM(s.quantity_sold) AS total_quantity_sold, 
                   SUM(s.selling_price * s.quantity_sold) AS total_revenue
            FROM sales s
            JOIN products p ON s.product_id = p.product_id
            WHERE s.sale_date BETWEEN :start_date AND :end_date
            GROUP BY p.product_name, p.buying_price, s.selling_price";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    $report = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Inventory Management System</h2>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="sales_tracking.php">Sales</a></li>
            <li><a href="sales_reports.php" class="active">Sales Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Sales Report</h1>
        <div class="date-range">
            <h2>Select Date Range</h2>
            <form action="sales_reports.php" method="post">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
                <button type="submit">Generate Report</button>
            </form>
        </div>

        <?php if (!empty($report)): ?>
        <div class="report-results">
            <h2>Sales Report from <?= htmlspecialchars($start_date); ?> to <?= htmlspecialchars($end_date); ?></h2>
            <table class="table-report">
                <tr>
                    <th>Product Name</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Total Quantity Sold</th>
                    <th>Total Revenue</th>
                </tr>
                <?php foreach ($report as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['product_name']); ?></td>
                        <td><?= htmlspecialchars($row['buying_price']); ?></td>
                        <td><?= htmlspecialchars($row['selling_price']); ?></td>
                        <td><?= htmlspecialchars($row['total_quantity_sold']); ?></td>
                        <td><?= htmlspecialchars($row['total_revenue']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
