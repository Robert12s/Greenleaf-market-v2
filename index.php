<?php
	/** 
	 * @author Robert Twelves
	 * @created 05/02/2025
	 */

    require_once('configs/common.php');

    use MyProject\Common;
    
    class Index extends Common {
    
        public function __construct() {
            parent::__construct(); // Ensure Common constructor runs
            $this->init();
            $this->proccess();
        }
    
        public function init() {
            // Fetch products data from the API and assign to smarty
            $this->products = $this->apiRequest('GET', 'products');
            $this->categories = $this->apiRequest('GET', "categories");

            // Check if the form for creating a new product was submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
                $this->createProduct(); // Call the function to create the product
            }
        }

        private function createProduct() {
            $newProductData = [
                'name'        => $_POST['name'],
                'about'       => $_POST['about'],
                'category_id' => $_POST['category_id'],
                'price'       => $_POST['price'],
                'stock'       => $_POST['stock']
            ];

            $response = $this->apiRequest('POST', "products/create", $newProductData);

            if (isset($response['message'])) {
                $_SESSION['message'] = 'Product created successfully';
            } else {
                $_SESSION['error'] = 'Error creating product';
            }

            // reload the page
            header("Location: /index");
            exit;

        }
    
        public function proccess() {
            $this->smarty->assign('session', $_SESSION);

            // Clear flash messages after they are displayed
            if (isset($_SESSION['message'])) {
                unset($_SESSION['message']);  // Clear the success message
            }

            if (isset($_SESSION['error'])) {
                unset($_SESSION['error']);  // Clear the error message
            }
            
            $this->display('index/main.tpl'); 
        }
    }
    
    new Index();