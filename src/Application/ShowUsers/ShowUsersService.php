<?php

namespace App\Application\ShowUsers;

use App\Application\Shared\Model\User\IUserCollectionDataTransformer;
use App\Domain\User\IUserRepository;

class ShowUsersService
{
    private IUserRepository $userRepository;

    private IUserCollectionDataTransformer $userCollectionDataTransformer;

    public function __construct(
        IUserRepository $userRepository,
        IUserCollectionDataTransformer $userCollectionDataTransformer)
    {
        $this->userRepository = $userRepository;
        $this->userCollectionDataTransformer = $userCollectionDataTransformer;
    }

    public function execute(): void
    {
        $users = $this->userRepository->getAll();

        $this->userCollectionDataTransformer->write($users);
    }

    public function userCollectionDataTransformer(): IUserCollectionDataTransformer
    {
        return $this->userCollectionDataTransformer;
    }

}