<?php

// 1. Define allowed origins
$allowed_origins = [
    "http://localhost:4173", // Common React port
    "http://localhost:5173", // Common Vite port
    "http://127.0.0.1:5500", // Live Server port
    "https://react-tanstack-router-graphql.onrender.com",
];

// 2. Check if the requesting origin is in our allowed list
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $origin);
}

// 3. Essential CORS Headers
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true"); // Required if sending cookies/sessions

// 4. Handle Preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Return 204 No Content for the preflight check
    http_response_code(204);
    exit;
}
