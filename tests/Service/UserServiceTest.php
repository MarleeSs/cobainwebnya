<?php

namespace Login\Management\PHP\Service;

use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\User;
use Login\Management\PHP\Domain\UserDetail;
use Login\Management\PHP\Exception\ValidationException;
use Login\Management\PHP\Model\UserRegisterEmailRequest;
use Login\Management\PHP\Model\UserUpdateEmailRequest;
use Login\Management\PHP\Model\UserLoginRequest;
use Login\Management\PHP\Model\UserRegisterRequest;
use Login\Management\PHP\Model\UserUpdatePasswordRequest;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserDetailRepository;
use Login\Management\PHP\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->email = "marleess@gmail.com";
        $request->username = "marleess";
        $request->password = "cobadoang";

        $response = $this->userService->register($request);

        self::assertEquals($request->email, $response->user->email);
        self::assertEquals($request->username, $response->user->username);
        self::assertNotEquals($request->password, $response->user->password);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->email = '';
        $request->username = '';
        $request->password = '';

        $this->userService->register($request);
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->email = "marleess1@gmail.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->email = "marleess@gmail.com";
        $request->username = "marleess";
        $request->password = "cobadoang";

        $this->userService->register($request);
    }

//
    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->username = "marleess";
        $request->password = "cobadoang";

        $this->userService->login($request);
    }

//
    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = password_hash("cobadoang", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->username = "marleess";
        $request->password = "cobaganti";

        $this->userService->login($request);
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = password_hash("cobadoang", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->username = "marleess";
        $request->password = "cobadoang";

        $response = $this->userService->login($request);

        self::assertEquals($request->username, $response->user->username);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRequestEmailUpdate()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $user = new User();
        $user->email = "marleess2@gmail.com";
        $user->username = "marleess2";
        $user->password = "cobadoang";

        $this->userRepository->save($user);

        $request = new UserUpdateEmailRequest();
        $request->username = "marleess2";
        $request->email = "ganti@gmail.com";
        $this->userService->requestEmailUpdate($request);

        $result = $this->userRepository->findByUsername($user->username);

        self::assertEquals($request->email, $result->email);
        self::assertNotNull($result->email_updated_at);

    }

    public function testUpdatePasswordSucces()
    {
        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = password_hash("cobaaja", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest();
        $request->username = $user->username;
        $request->oldPassword = "cobaaja";
        $request->newPassword = "cobaganti";

        $this->userService->updatePassword($request);

        $result = $this->userRepository->findByUsername($user->username);
        self::assertTrue(password_verify($request->newPassword, $result->password));
        self::assertNotNull($result->password_updated_at);

    }

    public function testUpdatePasswordWrong()
    {
        $this->expectException(ValidationException::class);

        $user = new User();
        $user->email = "marleess@gmail.com";
        $user->username = "marleess";
        $user->password = password_hash("cobaaja", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest();
        $request->username = $user->username;
        $request->oldPassword = "tapiboong";
        $request->newPassword = "cobaganti";

        $this->userService->updatePassword($request);
    }


    protected function setUp(): void
    {
        $connection = Database::getConnection();

        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $this->sessionRepository = new SessionRepository($connection);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }
}
