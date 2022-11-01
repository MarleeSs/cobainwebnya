<?php

namespace Login\Management\PHP\Domain;

class User
{
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $created_at = null;
    public ?string $password_updated_at = null;
    public ?string $email_updated_at = null;
}