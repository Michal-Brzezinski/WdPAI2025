<?php

require_once 'AppController.php';
require_once 'DashboardController.php';
require_once __DIR__ . "/../repository/UserRepository.php";

// TODO TUTAJ Z TEGO DOKUMENTU GOOGLE DODAĆ DO WŁASNYCH POTRZEB MECHANIZM AUTENTYKACJI
class SecurityController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    public function login()
    {
        // dekorator, który definiuje, jakie metody HTTP są dostępne (jest w AppController)
        if (!$this->allowMethods(['GET', 'POST'])) {
            http_response_code(405); // Method Not Allowed
            return $this->render('405', ['message' => 'Method not allowed']);
        }

        if ($this->isGet()) {
            return $this->render("login");
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['message' => 'Fill all fields']);
        }

        // get data from database
        $user = $this->userRepository->getUserByEmail($email);

        if (!$user) {
            return $this->render('login', ['message' => 'User not found']);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->render('login', ['message' => 'Wrong password']);
        }

        // TODO create user session (żeby wiedzieć czy użytkownik jest zalogowany czy nie)

        // Tworzymy sesję użytkownika
        session_regenerate_id(true); // nowy identyfikator sesji (bezpieczeństwo)

        $_SESSION['user_id'] = $user['id'];          // zakładam, że w tablicy $user jest klucz 'id'
        $_SESSION['user_email'] = $user['email'];    // zapamiętujemy np. e-mail
        $_SESSION['user_firstname'] = $user['firstname'] ?? null;

        // ewentualnie możesz dodać prostą flagę:
        $_SESSION['is_logged_in'] = true;

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function logout()
    {
        // upewniamy się, że sesja jest uruchomiona
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // czyścimy wszystkie dane sesji
        $_SESSION = [];

        // opcjonalnie, kasujemy ciasteczko sesji po stronie przeglądarki
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // niszczymy sesję
        session_destroy();

        // przekierowanie np. na ekran logowania
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }

    public function register()
    {

        if ($this->isGet()) {
            return $this->render("register");
        }

        // pobranie z formularza email i hasła
        $email = $_POST["email"] ?? '';
        $password1 = $_POST["password1"] ?? '';
        $password2 = $_POST["password2"] ?? '';
        $firstname = $_POST["firstname"] ?? '';
        $lastname = $_POST["lastname"] ?? '';

        if (empty($email) || empty($password1) || empty($firstname)) {
            return $this->render('register', ['message' => 'Fill all fields']);
        }

        if ($password1 !== $password2) {
            return $this->render('register', ['message' => 'passwords should be the same!']);
        }

        // check if user with this email already exists
        if ($this->userRepository->getUserByEmail($email) != false) {
            return $this->render('register', ['message' => 'This email is already in use. Try to sign in.']);
        }

        $hashedpassword = password_hash($password1, PASSWORD_BCRYPT);

        // insert do bazy danych
        $this->userRepository->createUser(
            $email,
            $hashedpassword,
            $firstname,
            $lastname
        );

        // TODO zwrocenie informajci o pomyslnym zarejestrowaniu
        return $this->render("login", ["message" => "Zarejestrowano uytkownika " . $email]);
    }
}
