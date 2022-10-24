<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserEmail;
use App\Domain\User\UserId;
use App\Infrastructure\Model\Paginate;
use Doctrine\ORM\EntityManager;
use App\Domain\User\IUserRepository;
use App\Domain\User\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findByEmail(UserEmail $email): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $email->email()]);
    }

    public function findById(UserId $id): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(['id' => $id->id()]);
    }

    public function getAll(): array
    {
         return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

    public function getPaginated($page = 1, $perPage = 15): Paginate
    {
        $query = $this->em
            ->getRepository(User::class)
            ->createQueryBuilder('u')
            ->getQuery();

        $paginator = $this->paginate($query, $page, $perPage);

        $users = [];
        foreach ($paginator as $user) {
            $users[] = $user;
        }

        $totalItems = count($paginator);

        return new Paginate($page, $perPage, $totalItems, $users);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
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

    private function paginate($query, $page = 1, $perPage = 15): Paginator
    {
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($perPage * ($page - 1))
            ->setMaxResults($perPage);

        return $paginator;
    }
}