<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/CardsRepository.php';

class DashboardController extends AppController
{

    private $cardsRepository;

    public function __construct()
    {
        $this->cardsRepository = new CardsRepository();
    }

    public function index()
    {
        $this->requireLogin();
        //$userRepository

        return $this->render("dashboard", ['cards' => []]);
    }

    public function search()
    {
        $this->requireLogin();

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType !== 'application/json') {
        }
        header('Content-Type: application/json; charset=utf-8');

        //TODO get searchtag from searchbar

        echo json_encode($this->cardsRepository->getCardsByTitle('Heart'));
        return;

        // jak nie zadziała ze zdjęć to naprawić z czatem albo wkleić kod z docsa PHP JSON
    }
}
