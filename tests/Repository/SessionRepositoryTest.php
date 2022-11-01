<?php

namespace Login\Management\PHP\Repository;

use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\Session;
use Login\Management\PHP\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function testSaveSuccess()
    {

        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = "marleess";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findByUsername($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userUsername, $result->userUsername);
    }

    public function testFindByUsernameSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = "marleess";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findByUsername($session->id);

        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userUsername, $result->userUsername);

    }

    public function testFindByUsernameNotFound()
    {
        $result = $this->sessionRepository->findByUsername('notfound');
        self::assertNull($result);
    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->userUsername = "marleess";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findByUsername($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->userUsername, $result->userUsername);

        $this->sessionRepository->deleteByUsername($session->id);

        $result = $this->sessionRepository->findByUsername($session->id);
        self::assertNull($result);
    }

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->username = "marleess";
        $user->email = "marleess@gmail.com";
        $user->password = "cobadoang";

        $this->userRepository->save($user);
    }


}
