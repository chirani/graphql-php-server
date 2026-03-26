<?php

use GraphQL\GraphQL;

require_once __DIR__ . '/../vendor/autoload.php';

use App\MyGraphql\SchemaBuilder;

require __DIR__ . "/cors.php";

$router = new \Bramus\Router\Router();

$router->before('GET|POST|PUT|DELETE', '/api/.*', function () {
    header('Content-Type: application/json');
});

$router->post('/api/graphql', function () {
    require_once __DIR__ . '/../bootstrap.php';
    try {
        $schema = SchemaBuilder::build($entityManager);
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'] ?? null;
        $variables = $input['variables'] ?? null;

        if (!$query) {
            throw new Exception("No query provided.");
        }

        $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
        $output = $result->toArray();
    } catch (Exception $e) {
        $output = [
            'errors' => [
                ['message' => $e->getMessage()]
            ]
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($output);
    return json_encode($output);
});


$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo json_encode(['error' => 'Endpoint not found']);
});


$router->run();
