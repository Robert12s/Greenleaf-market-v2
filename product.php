<?php

/**
 * @author Robert Twelves
 * @created 06/03/2025
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('configs/common.php');

use MyProject\Common;

class ProductPage extends Common {

    private $product;

    public function __construct() {
        parent::__construct(); // Ensure Common constructor runs
        $this->init();
        $this->process();
    }

    public function init() {
        // Get product ID from URL
        $productId = $_GET['id'] ?? null;

        if (!$productId || !is_numeric($productId)) {
            die("Invalid product ID.");
        }

        // Fetch product data from API
        $productData = $this->apiRequest('GET', "products/getById/{$productId}");

        // fetch the category data for this product
        $productCategory = $this->apiRequest('GET', "categories/getById/{$productData['category_id']}");
        
        $productData['category'] = $productCategory['name'];
        $productData['category_id'] = $productCategory['id'];

        $categories = $this->apiRequest('GET', "categories");

        $this->smarty->assign('product', $productData);  // Assign product to template as the other way isn't working on this file
        $this->smarty->assign('categories', $categories);

         // Check if user is submitting an action (delete or update)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete'])) {
                $this->deleteProduct($productId);
            } elseif (isset($_POST['edit'])) {
                $this->editProduct($productId);
            }
        }    
    }

    private function deleteProduct($productId) {
        $response = $this->apiRequest('DELETE', "products/delete/{$productId}");

        if (isset($response['message'])) {
            $_SESSION['message'] = 'Product deleted successfully';
        } else {
            $_SESSION['error'] = 'Error deleting product';
        }

        // Redirect back to the index page
        header("Location: /index");
        exit;
    }

    private function editProduct($productId) {
        $updatedData = [
            'name'          => $_POST['name'],
            'about'         => $_POST['about'],
            'category_id'   => $_POST['category_id'],
            'price'         => $_POST['price'],
            'stock'         => $_POST['stock']
        ];

        $response = $this->apiRequest('PUT', "products/update/{$productId}", $updatedData);

        if (isset($response['message'])) {
            $_SESSION['message'] = 'Product updated successfully';
            header("Location: /product/{$productId}");  // Reload the page
            exit;
        } else {
             $_SESSION['error'] = 'Error updating product';
            header("Location: /product/{$productId}");  // Reload the page
            exit;
        }
    }

    public function process() {
        $this->smarty->assign('session', $_SESSION);
        // Clear flash messages after they are displayed
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);  // Clear the success message
        }

        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);  // Clear the error message
        }
        $this->display('product/main.tpl'); 
    }
}

new ProductPage();
