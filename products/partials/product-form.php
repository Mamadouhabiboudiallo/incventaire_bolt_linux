<?php
$isEdit = basename($_SERVER['PHP_SELF']) === 'edit.php';
$submitText = $isEdit ? 'Update Product' : 'Create Product';
?>

<form method="POST" action="">
    <div class="form-group">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" 
               value="<?php echo htmlspecialchars($product->name ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="barcode" class="form-label">Barcode</label>
        <input type="text" class="form-control" id="barcode" name="barcode" 
               value="<?php echo htmlspecialchars($product->barcode ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" 
               value="<?php echo htmlspecialchars($product->quantity ?? ''); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo $submitText; ?></button>
</form>