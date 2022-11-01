<?php

namespace Login\Management\PHP\Controller;

use Login\Management\PHP\App\View;
use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Exception\ValidationException;
use Login\Management\PHP\Model\UserLoginRequest;
use Login\Management\PHP\Model\UserRegisterRequest;
use Login\Management\PHP\Model\UserUpdateEmailRequest;
use Login\Management\PHP\Model\UserUpdatePasswordRequest;
use Login\Management\PHP\Repository\SessionRepository;
use Login\Management\PHP\Repository\UserRepository;
use Login\Management\PHP\Service\SessionService;
use Login\Management\PHP\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function postRegister()
    {
        $request = new UserRegisterRequest();
        $request->email = $_POST['email'];
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $this->userService->register($request);
            View::redirect('/user/login');
        } catch (ValidationException $exception) {
            View::render('User/register', [
                'title' => 'Register',
                'resource' => [
                    'images' => '../src/images/',
                    'style' => '../src/css/',
                    'javascript' => '../src/js/',
                ],
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function register()
    {
        View::render('User/register', [
            'title' => 'Create Account',
            'resource' => [
                'style' => '../src/css/',
                'javascript' => '../src/js/',
                'images' => '../src/images/'
            ]
        ]);
    }

    public function postLogin()
    {

        $request = new UserLoginRequest();
        $request->username = $_POST['username'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->login($request);

            $this->sessionService->create($response->user->username);

            View::redirect('/dashboard');
        } catch (ValidationException $exception) {
            View::render('User/login', [
                'title' => 'Sign In Account',
                'resource' => [
                    'images' => '../src/images/',
                    'style' => '../src/css/',
                    'javascript' => '../src/js/',
                ],
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function login(): void
    {
        View::render('User/login', [
            'title' => 'Sign In Account',
            'resource' => [
                'images' => '../src/images/',
                'style' => '../src/css/',
                'javascript' => 'src/js/',
            ],
        ]);
    }

    public function logout()
    {
        $this->sessionService->destroy();
        View::redirect('/');
    }

    public function accountSettings()
    {
        $user = $this->sessionService->current();
        View::render('Setting/account', [

            'title' => 'Account Setting',
            "user" => [
                "username" => $user->username,
                "email" => $user->email,
                "register_at" => $user->created_at,
                "last_update_email" => $user->email_updated_at,
                "last_update_password" => $user->password_updated_at,
            ],
            'resource' => [
                'images' => '../src/images/',
                'style' => '../src/css/',
                'javascript' => 'src/js/',
            ],
        ]);
    }

    public function postUpdateEmail()
    {
        $user = $this->sessionService->current();

        $request = new UserUpdateEmailRequest();
        $request->username = $user->username;
        $request->email = $_POST['email'];

        try {
            $this->userService->requestEmailUpdate($request);
            View::redirect('/setting/account');
        } catch (ValidationException $exception) {
            View::render('Setting/account', [
                'title' => 'Account Setting',
                "user" => [
                    "username" => $user->username,
                    "email" => $user->email,
                    "register_at" => $user->created_at,
                    "last_update_email" => $user->email_updated_at,
                    "last_update_password" => $user->password_updated_at,
                ],
                'resource' => [
                    'images' => '../src/images/',
                    'style' => '../src/css/',
                    'javascript' => 'src/js/',
                ],
                'error' => $exception->getMessage()
            ]);
        }

    }

    public function passwordSettings()
    {
        $user = $this->sessionService->current();
        View::render('Setting/password', [
            'title' => 'Password Setting',
            'resource' => [
                'images' => '../src/images/',
                'style' => '../src/css/',
                'black' => 'bg-black',
            ],
        ]);
    }

    public function postUpdatePassword()
    {
        $user = $this->sessionService->current();

        $request = new UserUpdatePasswordRequest();
        $request->username = $user->username;
        $request->oldPassword = $_POST['oldPassword'];
        $request->newPassword = $_POST['newPassword'];


        try {
            $this->userService->updatePassword($request);
            View::redirect('/setting/password');

        } catch (ValidationException $exception) {
            View::render('Setting/password', [
                'title' => 'Password Setting',
                'resource' => [
                    'images' => '../src/images/',
                    'style' => '../src/css/',
                    'javascript' => 'src/js/',
                    'black' => 'bg-black',
                ],
                'error' => $exception->getMessage(),
            ]);
        }

    }
}