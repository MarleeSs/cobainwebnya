<?php

namespace Login\Management\PHP\Controller;

use Login\Management\PHP\App\View;
use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserDetailRepository;
use Login\Management\PHP\Repository\UserRepository;
use Login\Management\PHP\Service\SessionService;
use Login\Management\PHP\Service\UserDetailService;
use Login\Management\PHP\Service\UserService;

class HomeController
{

    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::render('Home/index', [
                "title" => 'Home Page',
                "body" => 'bg-dark',
                'resource' => [
                    'bootstrap' => 'src/bootstrap/',
                    'style' => 'src/css/',
                    'javascript' => 'src/js/',
                    'images' => '../src/images/'
                ]
            ]);
        } else {
            View::render('Home/dashboard', [
                'title' => 'Marleess | Dashboard',
                "user" => [
                    "name" => $user->username
                ],
                'resource' => [
                    'images' => 'src/images/',
                    'bootstrap' => 'src/bootstrap/',
                    'style' => 'src/css/',
                    'javascript' => 'src/js/',
                ],
            ]);
        }

    }
}