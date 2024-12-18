<?php
require_once 'includes/init.php';
require_once 'includes/header.php';
echo "Test Apache    ";

echo "Chemin actuel : " . $_SERVER['REQUEST_URI'];

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
                <a href="<?php echo base_url('products/create.php'); ?>" class="btn btn-primary">Add Product</a>
                <a href="<?php echo base_url('products/create.php'); ?>" class="btn btn-primary">Add Customer</a>
                <a href="<?php echo base_url('reports/generate.php'); ?>" class="btn btn-secondary">Generate Report</a>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Recent Products</h2>
        </div>
        <div class="card-body">
            <?php include 'products/partials/product-list.php'; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>