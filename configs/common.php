<?php

/**
 * @author Robert Twelves
 * @created 05/02/2025
**/

namespace MyProject;

require_once __DIR__ . '/../inc/smarty/libs/Smarty.class.php';
require_once 'config.php';
use Smarty\Smarty;

class Common {
    protected $smarty;

    public function __construct() {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->smarty = new Smarty();

        // Set Smarty directories
        $this->smarty->setTemplateDir(__DIR__ . '/../templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../templates_c/');
        $this->smarty->setCacheDir(__DIR__ . '/../cache/');
        $this->smarty->setConfigDir(__DIR__ . '/configs/');
    }

    public function __set($name, $value) {
        $this->smarty->assign($name, $value);
    }

    // Single display() method with wrapper logic
    public function display($template) {
        $this->smarty->assign('content', $template);
        $this->smarty->display('page/wrapper.tpl');
    }

    public function apiRequest($method, $endpoint, $data = []) {
        $apiUrl = API_BASE_URL . $endpoint;

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // Set method (GET, POST, PUT, DELETE)

        // Check if we are sending data (for POST, PUT, or DELETE with body)
        if (!empty($data) && in_array($method, ['POST', 'PUT', 'DELETE'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Set HTTP headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Execute API call
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch);
        }

        curl_close($ch);

        // Decode response
        $decodedResponse = json_decode($response, true);

        // Check if decoding was successful
        if ($decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON Decode Error: " . json_last_error_msg();
        }

        return $decodedResponse;
    }
}