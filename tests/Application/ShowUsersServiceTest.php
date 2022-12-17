<?php

namespace App\Application;

use App\Application\ShowUsers\ShowUsersRequest;
use App\Application\ShowUsers\ShowUsersService;
use App\Domain\User\IPasswordHashing;
use App\Domain\User\User;
use App\Domain\User\UserEmail;
use App\Domain\User\UserName;
use App\Domain\User\UserPassword;
use App\Infrastructure\Auth\Hashing\BasicPasswordHashing;
use App\Infrastructure\Auth\Hashing\Md5PasswordHashing;
use App\Infrastructure\Model\User\InMemory\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class ShowUsersServiceTest extends TestCase
{
    private ShowUsersService $service;
    private InMemoryUserRepository $repository;
    private IPasswordHashing $passwordHashing;

    protected function setUp(): void
    {
        $this->repository = new InMemoryUserRepository();
        $this->service = new ShowUsersService(
            $this->repository
        );
        $this->passwordHashing = new BasicPasswordHashing();
    }

    /**
     * @test
     */
    public function shouldBeGetUsers()
    {
        $user = new User(
            $this->repository->nextIdentity(),
            new UserName('Jhon Doe'),
            new UserEmail('jhondoe@example.com'),
            UserPassword::fromPlaneText(
                '123*456',
                $this->passwordHashing
            )
        );

        $this->repository->save($user);

        $user2 = new User(
            $this->repository->nextIdentity(),
            new UserName('Fulano'),
            new UserEmail('Fulano@example.com'),
            UserPassword::fromPlaneText(
                '123*456',
                $this->passwordHashing
            )
        );

        $this->repository->save($user2);

        $user3 = new User(
            $this->repository->nextIdentity(),
            new UserName('Mengano'),
            new UserEmail('Mengano@example.com'),
            UserPassword::fromPlaneText(
                '123*456',
                $this->passwordHashing
            )
        );

        $this->repository->save($user3);

        $response = $this->service->execute(
            new ShowUsersRequest(1, 2)
        );

        $pagination = $response->pagination();

        $this->assertArrayHasKey('total', $pagination);
        $this->assertEquals(3, $pagination['total']);
        $this->assertArrayHasKey('per_page', $pagination);
        $this->assertEquals(2, $pagination['per_page']);
        $this->assertArrayHasKey('current_page', $pagination);
        $this->assertEquals(1, $pagination['current_page']);
        $this->assertArrayHasKey('last_page', $pagination);
        $this->assertEquals(2, $pagination['last_page']);
        $this->assertArrayHasKey('from', $pagination);
        $this->assertEquals(1, $pagination['from']);
        $this->assertArrayHasKey('to', $pagination);
        $this->assertEquals(2, $pagination['to']);
        $this->assertArrayHasKey('users', $pagination);
        $this->assertCount(2, $pagination['users']);
        $this->assertEquals(
            $user->getId(),
            $pagination['users'][0]['id']
        );
        $this->assertEquals(
            $user2->getId(),
            $pagination['users'][1]['id']
        );
        $this->assertArrayNotHasKey(
            'password',
            $pagination['users'][0]
        );
    }

    /**
     * @test
     */
    public function shouldBeGetEmpty()
    {
        $response = $this->service->execute(
            new ShowUsersRequest(2, 10)
        );

        $pagination = $response->pagination();

        $this->assertArrayHasKey('total', $pagination);
        $this->assertEquals(0, $pagination['total']);
        $this->assertArrayHasKey('per_page', $pagination);
        $this->assertEquals(10, $pagination['per_page']);
        $this->assertArrayHasKey('current_page', $pagination);
        $this->assertEquals(2, $pagination['current_page']);
        $this->assertArrayHasKey('last_page', $pagination);
        $this->assertEquals(0, $pagination['last_page']);
        $this->assertArrayHasKey('from', $pagination);
        $this->assertEquals(0, $pagination['from']);
        $this->assertArrayHasKey('to', $pagination);
        $this->assertEquals(0, $pagination['to']);
        $this->assertArrayHasKey('users', $pagination);
        $this->assertCount(0, $pagination['users']);
    }
}