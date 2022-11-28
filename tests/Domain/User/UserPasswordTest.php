<?php

namespace App\Domain\User;

use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    private string $password;

    public function setUp(): void
    {
        $this->password = 'a!@ 123';
    }

    /**
     * @test
     */
    public function shouldCreateAnUserPassword()
    {
        $userPassword = UserPassword::fromPassword($this->password);
        $this->assertInstanceOf(UserPassword::class, $userPassword);
    }

    /**
     * @test
     */
    public function shouldBeVerifiable()
    {
        $userPassword = UserPassword::fromPassword($this->password);
        $isValid = password_verify($this->password, $userPassword->hash());
        $this->assertEquals(true, $isValid);
        $isValid = password_verify($this->password.'s', $userPassword->hash());
        $this->assertEquals(false, $isValid);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongUserPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The password entered exceeds the length of 50.");
        $this->expectExceptionCode(422);
        $userPassword = UserPassword::fromPassword(str_repeat('a', 51));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithAShortUserPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The entered password must have a minimum of 4 characters.");
        $this->expectExceptionCode(422);
        $userPassword = UserPassword::fromPassword(str_repeat('a', 3));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongHash()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The hash exceeds the length of 100.");
        $this->expectExceptionCode(422);
        $userPassword = UserPassword::fromHash(str_repeat('a', 101));
    }
}