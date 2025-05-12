<?php

/**
 * @author Robert Twelves
 * @created 03/03/2025
**/

class Products {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    //gets all products information
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //gets the product infomation for a perticular product id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //Creates a product
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, about, stock, price, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidi", $data['name'], $data['about'], $data['stock'], $data['price'], $data['category_id']);
        return $stmt->execute() ? ["message" => "Product added"] : ["error" => "Insert failed"];
    }


    //Updates a product
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, about = ?, stock = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssiddi", $data['name'], $data['about'], $data['stock'], $data['price'], $data['category_id'], $id);
        return $stmt->execute() ? ["message" => "Product updated"] : ["error" => "Update failed"];
    }


    //Deletes a product
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() ? ["message" => "Product deleted"] : ["error" => "Delete failed"];
    }
}
?>