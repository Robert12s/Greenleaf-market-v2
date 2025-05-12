<?php
    /** 
    * @author Robert Twelves
    * @created 05/03/2025
    */

    require_once('configs/common.php');

    use MyProject\Common;

    class Login extends Common {

        public function __construct() {
            parent::__construct();
            $this->init();  // Initialize the login process
            $this->process(); // Handle the display of the login form
        }

        public function init() {
             // Check if the user is already logged in
            if (isset($_SESSION['user'])) {
                // If logged in, we will show account details
                $this->smarty->assign('user', $_SESSION['user']);
                $this->display('login/account.tpl'); // Load the account template
                exit;
            }
        
            //handle login
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Fetch POST data
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';

                // Basic validation for required fields
                if (empty($email) || empty($password)) {
                    $this->error = 'Email and password are required.';
                    return; // Stop execution if validation fails
                }

                // Send login request to the API
                $response = $this->apiRequest('POST', 'users/login', [
                    'email' => $email,
                    'password' => $password
                ]);

                // Check the response
                if (!empty($response['message']) && $response['message'] === 'Login successful') {
                    // If login is successful, store user data in session
                    $_SESSION['user'] = $response['user'];
                    header("Location: index.php"); // Redirect on success
                    exit; // Stop further execution
                } else {
                    // If login failed, store error message
                    $this->error = $response['error'] ?? 'Invalid login credentials';
                }
            }
        }

        public function process() {
            // Display the login template
            $this->display('login/login.tpl');
        }
    }

    new Login();


