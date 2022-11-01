<?php

namespace Login\Management\PHP\Model;

class UserUpdatePasswordRequest
{
    public ?string $username = null;
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
}