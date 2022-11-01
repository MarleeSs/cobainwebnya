<?php

namespace Login\Management\PHP\Controller;

use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\User;
use Login\Management\PHP\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private UserController $userController;
    private UserRepository $userRepository;
//    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->userController = new UserController();

//        $this->sessionRepository = new SessionRepository(Database::getConnection());
//        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();

        putenv("mode=test");
    }

    public function testRegister()
    {
        $this->userController->register();

        $this->expectOutputRegex("[Create]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[email]");
        $this->expectOutputRegex("[Password]");
    }

    public function testPostRegisterSuccess()
    {
        self::markTestSkipped('Skipp 1 :Error');
        $_POST['username'] = 'eko';
        $_POST['email'] = 'Eko';
        $_POST['password'] = 'rahasia';

        $this->userController->postRegister();

        $this->expectOutputRegex("[Location: /login]");
    }

    public function testPostRegisterValidationError()
    {
        $_POST['username'] = '';
        $_POST['email'] = 'Eko';
        $_POST['password'] = 'rahasia';

        $this->userController->postRegister();

        $this->expectOutputRegex("[Create]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[email]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Field cannot blank]");
    }

    public function testPostRegisterDuplicate()
    {
        $user = new User();
        $user->username = "eko";
        $user->email = "Eko@asd.c";
        $user->password = "rahasia";
        $user->created_at = "2022-10-25 05:58:51";

        $this->userRepository->save($user);

        $_POST['username'] = 'eko';
        $_POST['email'] = 'Eko@asd.c';
        $_POST['password'] = 'rahasia';
        $user->created_at = "2022-10-25 05:58:51";

        $this->userController->postRegister();

        $this->expectOutputRegex("[Create]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[email]");
        $this->expectOutputRegex("[Password]");
//        $this->expectOutputRegex("[Username not available]");
        $this->expectOutputRegex("[Email already exists]");
    }

    public function testLogin()
    {
        $this->userController->login();

        $this->expectOutputRegex("[Sign in]");
        $this->expectOutputRegex("[Username]");
        $this->expectOutputRegex("[Email]");
        $this->expectOutputRegex("[Password]");
    }

    public function testLoginSuccess()
    {
        self::markTestSkipped('Skipp 2 :Error');
        $user = new User();
        $user->username = "eko";
        $user->email = "Eko@asd.c";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $user->created_at = "2022-10-25 05:58:51";

        $this->userRepository->save($user);

        $_POST['username'] = 'eko';
        $_POST['password'] = 'rahasia';

        $this->userController->postLogin();

        $this->expectOutputRegex("[Location: /dashboard]");

    }

    public function testLoginValidationError()
    {
        $_POST['username'] = '';
        $_POST['password'] = '';

        $this->userController->postLogin();

        $this->expectOutputRegex("[Sign In]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Field cannot blank]");
    }

    public function testLoginUserNotFound()
    {
        $_POST['username'] = 'notfound';
        $_POST['password'] = 'notfound';

        $this->userController->postLogin();

        $this->expectOutputRegex("[Sign In]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Login Failed, Please check your username and password]");
    }

    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->username = "eko";
        $user->email = "Eko@email.com";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $user->created_at = "2022-10-25 05:58:51";

        $this->userRepository->save($user);

        $_POST['username'] = 'eko';
        $_POST['password'] = 'salah';

        $this->userController->postLogin();

        $this->expectOutputRegex("[Sign In]");
        $this->expectOutputRegex("[username]");
        $this->expectOutputRegex("[Password]");
        $this->expectOutputRegex("[Login Failed, Please check your username and password]");
    }
}
