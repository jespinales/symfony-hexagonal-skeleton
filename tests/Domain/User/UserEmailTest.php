<?php

namespace App\Domain\User;

use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{
    private string $email;

    public function setUp(): void
    {
        $this->email = 'jhon_doe@example.com';
    }

    public function shouldCreateAnUserEmail()
    {
        $userEmail = new UserEmail($this->email);
        $this->assertInstanceOf(UserEmail::class, $userEmail);
    }

    /**
     * @test
     */
    public function shouldBeEqual()
    {
        $userEmail1 = new UserEmail($this->email);
        $userEmail2 = new UserEmail($this->email);
        $this->assertEquals(true, $userEmail1->equals($userEmail2));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongUserEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The email entered exceeds the length of 100.");
        $this->expectExceptionCode(422);
        $userEmail = new UserEmail(str_repeat('a', 100).'@example.com');
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The email entered hasn't a valid format.");
        $this->expectExceptionCode(422);
        $userEmail = new UserEmail('example');
    }

}