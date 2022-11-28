<?php

namespace App\Domain\User;

interface IUserRepository
{
    public function nextIdentity(): UserId;

    public function findByEmail(UserEmail $email): ?User;

    public function findById(UserId $id): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;

    /**
     * Return users by pages
     *
     * This method is an infrastructure problem
     *
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function getPaginated($page = 1, $perPage = 15);

    public function save(User $user): void;

    public function deleteById(UserId $id): void;
}