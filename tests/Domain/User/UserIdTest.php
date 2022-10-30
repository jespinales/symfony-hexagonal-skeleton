<?php

namespace App\Domain\User;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserIdTest extends TestCase
{
    private string $uuid;

    public function setUp(): void
    {
        $this->uuid = Uuid::uuid1();
    }

    /**
     * @test
     */
    public function shouldBeEqual()
    {
        $userId1 = new UserId($this->uuid);
        $userId2 = new UserId($this->uuid);
        $this->assertEquals(true, $userId1->equals($userId2));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongUserId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The id entered exceeds the length of 36");
        $this->expectExceptionCode(422);
        $userId = new UserId($this->uuid.'a');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The id entered is invalid");
        $this->expectExceptionCode(422);
        $userId = new UserId(substr($this->uuid, 0, strlen($this->uuid)-1).' ');
    }
}