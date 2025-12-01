<?php

require_once 'Repository.php';

class UserRepository extends Repository
{

    public function getUsers(): ?array
    {
        $stmt = $this->database->prepare('SELECT * FROM users');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function getUserByEmail(string $email)
    {
        $stmt = $this->database->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $users = $stmt->fetch(PDO::FETCH_ASSOC); // Jeśli brak użytkownika, $user = false

        return $users; // Zwróci false, jeśli nie znaleziono użytkownika
    }

    public function createUser(string $email, string $hashedpassword, string $firstname, string $lastname)
    {
        // zrobić to w bloku try-catch i wtedy wywołać komunikat dodane/nie dodano usera
        $stmt = $this->database->prepare('
        INSERT INTO users (email, password, firstName, lastname) VALUES(?,?,?,?);
        ');
        $stmt->execute([
            $email,
            $hashedpassword,
            $firstname,
            $lastname
        ]);
    }
}
