<?php
require_once 'config/Database.php';
require_once 'models/Product.php';
require_once 'models/Customer.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize models
$product = new Product($db);
$customer = new Customer($db);

// Get total products
$stmt = $product->read();
$total_products = $stmt->rowCount();

// Get total customers
$stmt = $customer->read();
$total_customers = $stmt->rowCount();

// Include header
require_once 'includes/header.php';
?>

<div class="container">
    <h1 class="mb-4">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="inventory-stats">
        <div class="stat-card">
            <h3><?php echo $total_products; ?></h3>
            <p>Total Products</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total_customers; ?></h3>
            <p>Total Customers</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Quick Actions</h2>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <a href="/products/create.php" class="btn btn-primary">Add Product</a>
                <a href="/customers/create.php" class="btn btn-primary">Add Customer</a>
                <a href="/reports/generate.php" class="btn btn-secondary">Generate Report</a>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Recent Products</h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Quantity</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $product->read();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['barcode']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="card">
        <div class="card-header">
            <h2>Recent Customers</h2>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $customer->read();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Include footer
require_once 'includes/footer.php';
?>