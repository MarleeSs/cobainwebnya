<?php

namespace Login\Management\PHP\Repository;

use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    protected UserRepository $userRepository;

    public function testSaveSuccess()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $result = $this->userRepository->findByUsername($user->username);

        self::assertEquals($user->username, $result->username);
        self::assertEquals($user->password, $result->password);
        self::assertNotNull($result->created_at);

    }

    public function testFindByUsernameFound()
    {
        $user = $this->userRepository->findByUsername("not found");
        self::assertNull($user);
    }

    public function testUpdateEmail()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $this->userRepository->updateEmail($user);

        $result = $this->userRepository->findByUsername($user->username);

        self::assertEquals($user->email, $result->email);
        self::assertNotNull($result->email_updated_at);
    }

    public function testUpdatePassword()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $user = new User();
        $user->password = "gantidong";
        $user->username = "marleess";
        $this->userRepository->updatePassword($user);

        $result = $this->userRepository->findByUsername($user->username);

        self::assertEquals($user->password, $result->password);
        self::assertNotNull($result->password_updated_at);
    }

    public function testFindByUsername()
    {
        $timeStamp = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $user = new User();
        $user->email = "marleess@gmial.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $user = $this->userRepository->findByUsername($user->username);
        self::assertSame($user->username, "marleess");
        self::assertSame($user->created_at, $timeStamp->format('Y-m-d H:i:s'));
    }

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();

    }
}
