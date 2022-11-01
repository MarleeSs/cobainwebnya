<?php

namespace Login\Management\PHP\Model;

class UserRegisterRequest
{
    public ?string $email = null;
    public ?string $username = null;
    public ?string $password = null;
}