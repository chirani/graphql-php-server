<?php

namespace App\Http;

class Response
{
    public static function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');

        echo json_encode($data);
        exit;
    }

    public static function error(string $message, int $status): void
    {
        self::json([
            'status' => $status,
            'message' => $message
        ], $status);
    }
}
