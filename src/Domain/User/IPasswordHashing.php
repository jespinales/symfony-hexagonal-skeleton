<?php

namespace App\Domain\User;

interface IPasswordHashing
{
    /**
     *	@param string $password
     *	@param string $hash
     *	@return bool
     */
    public function verify(string $password, string $hash): bool;

    public function passwordHashing(string $password): string;
}