<?php

namespace App\Application\Shared\Model\User;

use App\Domain\User\User;

class DtoUserCollectionDataTransformer implements IUserCollectionDataTransformer
{
    private array $data = [];

    private DtoUserDataTransformer $dtoUserDataTransformer;

    public function __construct(DtoUserDataTransformer $dtoUserDataTransformer)
    {
        $this->dtoUserDataTransformer = $dtoUserDataTransformer;
    }

    /**
     * @param User[] $users
     */
    public function write(array $users): self
    {
        foreach ($users as $user) {
            array_push(
                $this->data,
                $this->dtoUserDataTransformer
                    ->write($user)
                    ->read()
            );
        }

        return $this;
    }

    public function read(): array
    {
        return $this->data;
    }
}