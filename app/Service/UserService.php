<?php

namespace Login\Management\PHP\Service;

use Exception;
use Login\Management\PHP\Config\Database;
use Login\Management\PHP\Domain\User;
use Login\Management\PHP\Event\UserEvent;
use Login\Management\PHP\Exception\ValidationException;
use Login\Management\PHP\Model\UserLoginRequest;
use Login\Management\PHP\Model\UserResponse;
use Login\Management\PHP\Model\UserRegisterRequest;
use Login\Management\PHP\Model\UserUpdateEmailRequest;
use Login\Management\PHP\Model\UserUpdatePasswordRequest;
use Login\Management\PHP\Repository\UserRepository;
use SebastianBergmann\Type\TrueType;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ValidationException
     */
    public function register(UserRegisterRequest $request): UserResponse
    {
        $this->validateUserRegistrationRequest($request);

        try {
//            Prepare Database transaction
            Database::beginTransaction();

            $userEmail = $this->userRepository->findByEmail($request->email);
            if ($userEmail != null) {
                throw new ValidationException("Email already exists");
            }

            $user = $this->userRepository->findByUsername($request->username);
            if ($user != null) {
                throw new ValidationException("Username not available");
            }

//            Save data to database
            $user = new  User();
            $user->email = trim($request->email);
            $user->username = trim($request->username);
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

//            Response
            $response = new UserResponse();
            $response->user = $user;

//            Commit transaction
            Database::commitTransaction();
            return $response;

//            Rollback transaction
        } catch (Exception $exception) {
            Database::rollBackTransaction();
            throw $exception;
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateUserRegistrationRequest(UserRegisterRequest $request): void
    {
        if ($request->email == null || $request->username == null || $request->password == null ||
            trim($request->email) == '' || trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException('Field cannot blank');
        }
    }

    /**
     * @throws ValidationException
     */
    public function login(UserLoginRequest $userLoginRequest): UserResponse
    {
        $this->validateUserLoginRequest($userLoginRequest);

        $user = $this->userRepository->findByUsername(trim($userLoginRequest->username));
        if ($user == null) {
            throw new ValidationException("Login Failed, Your username and password gone wrong");
        }

        if (password_verify($userLoginRequest->password, $user->password)) {
            $response = new UserResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("Login Failed, Your username and password gone wrong");
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateUserLoginRequest(UserLoginRequest $request): void
    {
        if ($request->username == null || $request->password == null ||
            trim($request->username) == '' || trim($request->password) == '') {
            throw new ValidationException('Field cannot blank');
        }
    }

    public function requestEmailUpdate(UserUpdateEmailRequest $request): UserResponse
    {
        $this->validateUserEmailUpdateRequest($request);

        try {
            Database::beginTransaction();

            $user = $this->userRepository->findByEmail($request->email);
            if ($user != null) {
                throw new ValidationException("Email already exist");
            }

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;

            $this->userRepository->updateEmail($user);

            Database::commitTransaction();

            $response = new UserResponse();
            $response->user = $user;
            return $response;
        } catch (Exception $exception) {
            Database::rollBackTransaction();
            throw $exception;
        }
    }

    private function validateUserEmailUpdateRequest(UserUpdateEmailRequest $request): void
    {
        if ($request->email == null || trim($request->email) == '') {
            throw new ValidationException('Field cannot blank');
        }
    }

    public function updatePassword(UserUpdatePasswordRequest $request): UserResponse
    {
        try {
            Database::beginTransaction();

            $user = $this->userRepository->findByUsername($request->username);

            if (!password_verify($request->oldPassword, $user->password)) {
                throw new ValidationException("Old password wrong ❌");
            }

            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->userRepository->updatePassword($user);

            $this->eventPasswordUpdate($request);

            Database::commitTransaction();
            $response = new UserResponse();
            $response->user = $user;
            return $response;

        } catch (Exception $exception) {

            Database::rollBackTransaction();
            throw $exception;
        }
    }

    private function eventPasswordUpdate(UserUpdatePasswordRequest $request): void
    {
        $user = $this->userRepository->findByUsername($request->username);
        if (password_verify($request->oldPassword, $user->password)) {
            throw new ValidationException("Your password successfully change ✅");
        }
    }

}