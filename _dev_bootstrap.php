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
    'host' => 'sql202.infinityfree.com',
    'port' => 3306,
    'dbname' => 'if0_41596044_my_db_1',
    'user' => $username,
    'password' => $password,
    'charset' => 'utf8mb4',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
