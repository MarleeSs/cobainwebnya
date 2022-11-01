<?php

namespace Login\Management\PHP\Model;

class UserRegisterEmailRequest extends \Login\Management\PHP\Model\UserUpdateEmailRequest
{
    public ?string $username = null;
    public ?string $email = null;
}