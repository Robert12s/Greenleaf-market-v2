<?php

/**
 * @author Robert Twelves
 * @created 03/03/2025
 **/

class Users {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['email'], $data['password']);

        return $stmt->execute() ? ["message" => "User added"] : ["error" => "Insert failed"];
    }

    public function update($id, $data) {
        // Ensure password is updated if present
        if (isset($data['password'])) {
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $data['name'], $data['email'], $data['password'], $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssi", $data['name'], $data['email'], $id);
        }

        return $stmt->execute() ? ["message" => "User updated"] : ["error" => "Update failed"];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute() ? ["message" => "User deleted"] : ["error" => "Delete failed"];
    }

    public function login($email, $password) {
        // Retrieve the user by email
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            // Check if the password matches the stored plain text password
            if ($user['password'] === $password) {
                // On successful login, return user data (excluding the password)
                unset($user['password']);
                return ["message" => "Login successful", "user" => $user];
            } else {
                return ["error" => "Incorrect password"];
            }
        }
    }
}
  
