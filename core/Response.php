<?php

namespace App\Core;

class Response
{
  public static function json($data, $statusCode)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
  }

  public static function message($data, $statusCode)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo ($data);
    exit();
  }
}
