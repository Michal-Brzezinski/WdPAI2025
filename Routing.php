<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

class Routing {

    public static $routes = [
        'login' => [
            'controller' => 'SecurityController',
            'action' => 'login'
        ],
        'register' => [
            'controller' => 'SecurityController',
            'action' => 'register'
        ],
        'dashboard' => [
            'controller' => 'DashboardController',
            'action' => 'index'
        ],
    ];
    // TABLICA ASOCJACYJNA

    // trzeba za pomocą regexa zmienić zmienną path tak, aby można było w
    // przyszłości wyświetlać detale dla poszczególnych stron np dashboard 
    // o id-521, id=432 itp

    // w singleton to wsadzić tak, żeby obiekty kontrolerów nie tworzyły się
    // bez końca

    public static function run(string $path) {
        // TODO na podstawie sciezki sprawdzamy jaki HTML zwrocic
        switch ($path) {
    case 'dashboard':
    case 'login':
    case 'register':
        $controller = Routing::$routes[$path]['controller'];
        $action = Routing::$routes[$path]['action'];

        $controllerObj = new $controller();
        $controllerObj->$action();
        break;

    default:
        include 'public/views/404.html';
        break;
} 
    }
}