<?php

require_once 'AppController.php';

// TODO TUTAJ Z TEGO DOKUMENTU GOOGLE DODAĆ DO WŁASNYCH POTRZEB MECHANIZM AUTENTYKACJI
class SecurityController extends AppController
{
    // TODO dekarator, który definiuje, jakie metody HTTP są dostępne
    public function login()
    {
        if ($this->isGet()) {
            return $this->render("login");
        }

        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';

        // TODO get data from database

        $this->render("dashboard"); // rozwiazanie z bledem ladowania kart i brakiem zmiany url
        // header('Location: /dashboard'); // rozwiazanie ze zmiana url i zaladowaniem kart
        // exit;
    }

    public function register()
    {
        // TODO pobranie z formularza email i hasła
        // TODO insert do bazy danych
        // TODO zwrocenie informajci o pomyslnym zarejstrowaniu

        if ($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST["email"] ?? '';
        $password1 = $_POST["password1"] ?? '';
        $password2 = $_POST["password2"] ?? '';
        $firstname = $_POST["firstname"] ?? '';
        $lastname = $_POST["lastname"] ?? '';


        // TODO insert to database user

        return $this->render("login", ["message" => "Zarejestrowano uytkownika " . $email]);
    }
}
