<?php

namespace Login\Management\PHP\Middleware;

use Login\Management\PHP\App\View;
use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserDetailRepository;
use Login\Management\PHP\Repository\UserRepository;
use Login\Management\PHP\Service\SessionService;

class IsNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function before(): void
    {
//        user session
        $userSession = $this->sessionService->current();
        if ($userSession != null) {
            View::redirect('/dashboard');
        }
    }

}