<?php
class Validator {
    public function validateProduct($product) {
        $errors = [];

        if (empty($product->name)) {
            $errors[] = "Product name is required.";
        }

        if (empty($product->barcode)) {
            $errors[] = "Barcode is required.";
        }

        if (!is_numeric($product->quantity) || $product->quantity < 0) {
            $errors[] = "Quantity must be a positive number.";
        }

        return $errors;
    }
}