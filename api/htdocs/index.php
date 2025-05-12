<?php

/**
 * @author Robert Twelves
 * @created 03/03/2025
 **/

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/users.php';
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/categories.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Get database connection
$conn = Database::getConnection();
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Get request details
$request_uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

// Extract resource and action (skip the "index" part)
$resource = $request_uri[1] ?? null; // e.g., "products"
$action   = $request_uri[2] ?? null; // e.g., "delete"
$id       = $request_uri[3] ?? null; // Optional: for actions that need an ID

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Debug logs for tracking requests
error_log("Requested URI: " . $_SERVER['REQUEST_URI']);
error_log("Resource: " . $resource);
error_log("Action: " . $action);
error_log("ID: " . $id);
error_log("Request Method: " . $method);  // Log the HTTP method

// Define valid resources and their respective handler classes
$validResources = [
    'users' => Users::class,
    'products' => Products::class,
    'categories' => Categories::class
];

// Check if the resource is valid
if (!isset($validResources[$resource])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid API endpoint"]);
    exit;
}

// Instantiate the appropriate handler class based on the resource
$apiHandler = new $validResources[$resource]($conn);

// Get the raw POST data (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        // Handle GET requests
        if ($action === 'getById' && $id) {
            echo json_encode($apiHandler->getById($id));
        } else {
            echo json_encode($apiHandler->getAll());
        }
        break;

    case 'POST':
        // Handle POST requests
        if ($resource === 'users' && $action === 'login') {
            // Handle login
            if (isset($data['email']) && isset($data['password'])) {
                echo json_encode($apiHandler->login($data['email'], $data['password']));
            } else {
                echo json_encode(["error" => "Missing email or password"]);
            }
        } else {
            // Handle other POST actions (e.g., create new resource)
            echo json_encode($apiHandler->create($data));
        }
        break;

    case 'PUT':
        // Handle PUT requests (e.g., updating a resource)
        echo json_encode($apiHandler->update($id, $data));
        break;

    case 'DELETE':
        // Handle DELETE requests (e.g., deleting a resource)
        if ($id) {
            echo json_encode($apiHandler->delete($id));
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID is required for DELETE"]);
        }
        break;

    default:
        // Handle unsupported methods
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
}
