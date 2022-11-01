<?php

namespace Login\Management\PHP\Service;

use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\Session;
use Login\Management\PHP\Domain\User;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

function setCookie(string $name, string $value): void
{
    echo "$name: $value";
}

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function testCreate()
    {
        $session = $this->sessionService->create("marleess");

        $this->expectOutputRegex("[MARLEESS-SESSION: $session->id]");

        $result = $this->sessionRepository->findByUsername($session->id);

        self::assertEquals("marleess", $result->userUsername);
    }

    public function testDestroy()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = "marleess";

        $this->sessionRepository->save($session);

        $_COOKIE[ SessionService::COOKIE_NAME ] = $session->id;

        $this->sessionService->destroy();

        $this->expectOutputRegex("[MARLEESS-SESSION: ]");

        $result = $this->sessionRepository->findByUsername($session->id);
        self::assertNull($result);
    }

    public function testCurrent()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = "marleess";

        $this->sessionRepository->save($session);

        $_COOKIE[ SessionService::COOKIE_NAME ] = $session->id;

        $user = $this->sessionService->current();

        self::assertEquals($session->userUsername, $user->username);
    }

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->username = "marleess";
        $user->email = "marleess@gmail.com";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

    }
}
