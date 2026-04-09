<?php

use GraphQL\GraphQL;

require_once __DIR__ . '/../vendor/autoload.php';

use App\MyGraphql\SchemaBuilder;

require __DIR__ . "/cors.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

$router = new \Bramus\Router\Router();

$router->before('GET|POST|PUT|DELETE', '/api/.*', function () {
    header('Content-Type: application/json');
});

$router->get('/ping', function () {
    echo "HEYOO! \n";
    echo $_ENV["TEST_ENV"];
});

$router->post('/api/graphql', function () {
    echo "POINT 01 REACHED! \n";
    echo $_ENV["MYSQL_HOST"];

    require_once __DIR__ . '/../bootstrap.php';
    echo "POINT 02 REACHED! \n";
    try {
        $schema = SchemaBuilder::build($entityManager);
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'] ?? null;
        $variables = $input['variables'] ?? null;

        if (!$query) {
            throw new Exception("No query provided.");
        }
        echo "POINT 03 REACHED! \n";
        $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
        $output = $result->toArray();
    } catch (Exception $e) {
        echo "POINT 04 REACHED! \n";
        $output = [
            'errors' => [
                ['message' => $e->getMessage()]
            ]
        ];
    }
    echo "POINT 05 REACHED! \n";
    header('Content-Type: application/json');
    echo json_encode($output);
    return json_encode($output);
});


$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo json_encode(['error' => 'Endpoint not found']);
});


$router->run();
