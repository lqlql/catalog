<?php
declare(strict_types=1);

use Libs\DI;

require APP_PATH . '/startup/init.php';

$routes = DI::service('routes');
$config = DI::service('config');
if ('development' === $config['application']['env']) {
    ini_set('display_errors', 'On');
}

try {
    //routing
    $requestUrl = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $payload = file_get_contents('php://input') ?: '[]';
    $payload = json_decode($payload, true);
    if (!is_array($payload)) {
        throw new Exception('wrong.payload');
    }
    $route = $routes[$requestUrl] ?? null;
    if (!$route) {
        throw new Exception('wrong.url');
    }
    if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
        http_response_code(405);
        exit;
    }

    $controllerName = 'Controller\\' . $route['controller'];
    $controller = new $controllerName($payload);
    $response = $controller->{$route['action']}();
    if ($response) {
        echo json_encode($response);
    }

} catch (Throwable $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ]);
    http_response_code(404);
    exit;
}



