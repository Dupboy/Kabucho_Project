<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = $_POST['category_name'];
        $sql = "INSERT INTO categories (category_name) VALUES (:category_name)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':category_name', $category_name);
        if ($stmt->execute()) {
            echo "New category added successfully";
        } else {
            echo "Error adding category";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Inventory Management System</h2>
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="categories.php" class="active">Categories</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="sales_tracking.php">Sales</a></li>
            <li><a href="sales_reports.php">Sales Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Categories</h1>
        <div class="add-category">
            <h2>Add New Category</h2>
            <form action="categories.php" method="post">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required>
                <button type="submit" name="add_category" class="btn btn-add">Add Category</button>
            </form>
        </div>
        
        <div class="all-categories">
            <h2>All Categories</h2>
            <table class="table-categories">
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                </tr>
                <?php
                $sql = "SELECT * FROM categories";
                $result = $pdo->query($sql);
                $counter = 1;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$row['category_name']}</td>
                        </tr>";
                    $counter++;
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
