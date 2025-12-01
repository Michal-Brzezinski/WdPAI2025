<?php
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

class Routing
{
    private static $instance = null;
    private $routes = [];

    private function __construct()
    {
        $this->routes = [
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
    }

    public static function getInstance(): Routing
    {
        if (self::$instance === null) {
            self::$instance = new Routing();
        }
        return self::$instance;
    }

    public function run(string $path)
    {
        if (array_key_exists($path, $this->routes)) {
            $controller = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];

            $controllerObj = new $controller();
            $controllerObj->$action();
        } else {
            include 'public/views/404.html';
        }
    }
}
