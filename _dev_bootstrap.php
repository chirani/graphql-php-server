<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once "vendor/autoload.php";
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);

$username = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];
$host = $_ENV['MYSQL_HOST'];
$port = $_ENV['MYSQL_PORT'];
$dbname = $_ENV['MYSQL_DB'];

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => $host,
    'port' => $port,
    'dbname' => $dbname,
    'user' => $username,
    'password' => $password,
    'charset' => 'utf8mb4',
], $config);
// obtaining the entity manager

$entityManager = new EntityManager($connection, $config);
