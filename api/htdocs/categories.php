<?php

/**
 * @author Robert Twelves
 * @created 03/03/2025
**/

class Categories {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    //gets all catagories information
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //gets the category infomation for a perticular catagory id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //Creates a category
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $data['name']);
        return $stmt->execute() ? ["message" => "Category added"] : ["error" => "Insert failed"];
    }

    //Updates a category
    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $data['name'], $id);
        return $stmt->execute() ? ["message" => "Category updated"] : ["error" => "Update failed"];
    }

    //Deletes a category
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() ? ["message" => "Category deleted"] : ["error" => "Delete failed"];
    }
}
?>