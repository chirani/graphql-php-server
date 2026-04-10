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


$router->get('/db-check', function () {

    $username = $_ENV['MYSQL_USER'];
    $password = $_ENV['MYSQL_PASSWORD'];
    $host = $_ENV['MYSQL_HOST'];
    $port = $_ENV['MYSQL_PORT'];
    $dbname = $_ENV['MYSQL_DB'];

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        echo "Successfully connected to the managed database!";
    } catch (\PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
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
    return json_encode($output);
});


$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo json_encode(['error' => 'Endpoint not found']);
});


$router->run();
