<?php

namespace App\Domain\User;

class User
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $passwordHash;

    public function __construct(
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $password;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): UserName
    {
        return $this->name;
    }

    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    public function getPasswordHash(): UserPassword
    {
        return $this->passwordHash;
    }
}