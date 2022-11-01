<?php

namespace Login\Management\PHP\Service;

use Login\Management\PHP\Domain\Session;
use Login\Management\PHP\Domain\User;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserRepository;

class SessionService
{
    public const COOKIE_NAME = 'MARLEESS-SESSION';
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository,
                                UserRepository    $userRepository,
    )
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $username): Session
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = $username;

        $this->sessionRepository->save($session);

        setcookie(self::COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), '/');
        return $session;
    }

    public function destroy(): void
    {
        $sessionId = $_COOKIE[ self::COOKIE_NAME ] ?? '';
        $this->sessionRepository->deleteByUsername($sessionId);
        setcookie(self::COOKIE_NAME, '', 1, '/');
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[ self::COOKIE_NAME ] ?? '';

        $session = $this->sessionRepository->findByUsername($sessionId);

        if ($session == null) {
            return null;
        }

        return $this->userRepository->findByUsername($session->userUsername);
    }
}