<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $barcode;
    public $quantity;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET name=:name, barcode=:barcode, 
                    quantity=:quantity, created_at=:created_at";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":barcode", $this->barcode);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":created_at", $this->created_at);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET name=:name, barcode=:barcode, quantity=:quantity
                WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->barcode = htmlspecialchars(strip_tags($this->barcode));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":barcode", $this->barcode);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}