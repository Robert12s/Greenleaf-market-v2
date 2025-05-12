<?php
/**
 * @author Robert Twelves
 * @created 04/03/2025
**/

namespace MyProject;

// Detect if running locally or on the server
$apiBaseUrl = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') 
    ? "http://localhost/greenleafmarket/api/index.php/"
    : "http://greenleafapi.iceiy.com/index/";

// Define a constant to use throughout the app
define('API_BASE_URL', $apiBaseUrl);

?>