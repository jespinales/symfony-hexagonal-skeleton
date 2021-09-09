<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserEmail;
use App\Domain\User\UserId;
use Doctrine\ORM\EntityManager;
use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use Ramsey\Uuid\Uuid;

class DoctrineUserRepository implements IUserRepository
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function nextIdentity(): UserId
    {
        return new UserId(Uuid::uuid1());
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function findByEmail(UserEmail $email): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $email->email()]);
    }

    public function getAll(): array
    {
         return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function deleteById(UserId $id): void
    {
        $user = $this->em->getRepository(User::class)
            ->findOneBy(['id' => $id->id()]);

        if($user){
            $this->em->remove($user);
            $this->em->flush();
        }
    }
}