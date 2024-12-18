<?php
require_once 'vendor/autoload.php';

class ReportGenerator {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function generateInventoryReport() {
        $query = "SELECT * FROM products ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $html = '<h1>Inventory Report</h1>';
        $html .= '<table border="1">';
        $html .= '<tr><th>Name</th><th>Barcode</th><th>Quantity</th><th>Date Added</th></tr>';
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr>';
            $html .= '<td>' . $row['name'] . '</td>';
            $html .= '<td>' . $row['barcode'] . '</td>';
            $html .= '<td>' . $row['quantity'] . '</td>';
            $html .= '<td>' . $row['created_at'] . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }

    public function generateCustomerReport() {
        $query = "SELECT * FROM customers ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $html = '<h1>Customer Report</h1>';
        $html .= '<table border="1">';
        $html .= '<tr><th>Name</th><th>Email</th><th>Phone</th><th>Address</th></tr>';
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr>';
            $html .= '<td>' . $row['name'] . '</td>';
            $html .= '<td>' . $row['email'] . '</td>';
            $html .= '<td>' . $row['phone'] . '</td>';
            $html .= '<td>' . $row['address'] . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }
}