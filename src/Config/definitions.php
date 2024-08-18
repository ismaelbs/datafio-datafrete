<?php
declare(strict_types=1);

return [
  "app" => [
    "name" => $_ENV["APP_NAME"],
    "version" => $_ENV["APP_VERSION"],
    "displayErrorDetails" => (bool) $_ENV["APP_DISPLAY_ERROR_DATAILS"],
    "logErrors" => (bool) $_ENV["APP_LOG_ERRORS"],
    "logErrorDetails" => (bool) $_ENV["APP_LOG_ERROR_DETAILS"],
  ],
  "database" => [
    "driver" => $_ENV["DB_DRIVER"],
    "host" => $_ENV["DB_HOST"],
    "port" => $_ENV["DB_PORT"],
    "name" => $_ENV["DB_NAME"],
    "user" => $_ENV["DB_USER"],
    "password" => $_ENV["DB_PASS"],
  ],
  "cache" => [
    "host" => $_ENV["CACHE_HOST"],
    "port" => (int) $_ENV["CACHE_PORT"],
    "password" => $_ENV["CACHE_PASS"],
  ],
  "apis" => [
    "brasilapi" => [
      "url" => $_ENV["BRASILAPI_URL"],
    ],
  ],
];