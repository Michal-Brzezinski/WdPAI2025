<?php


class AppController
{

    protected function isGet(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'GET';
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }

    // dekorator, który definiuje, jakie metody HTTP są dostępne
    protected function allowMethods(array $methods): bool
    {
        return in_array($_SERVER["REQUEST_METHOD"], $methods);
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.html';
        $templatePath404 = 'public/views/404.html';
        $output = "";

        if (file_exists($templatePath)) {
            // ['items' => $cards]
            extract($variables);
            // $items = [ [id=> 1], [id=>2]]
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        } else {
            ob_start();
            include $templatePath404;
            $output = ob_get_clean();
        }
        echo $output;
    }

    protected function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            exit();
        }
    }
}
