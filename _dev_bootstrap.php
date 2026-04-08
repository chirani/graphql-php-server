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

$username = $_ENV['mysql_username'];
$password = $_ENV['mysql_password'];

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => 'maglev.proxy.rlwy.net',
    'port' => 36413,
    'dbname' => 'railway',
    'user' => $username,
    'password' => $password,
    'charset' => 'utf8mb4',
], $config);
// obtaining the entity manager

$entityManager = new EntityManager($connection, $config);
