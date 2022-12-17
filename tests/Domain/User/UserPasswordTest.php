<?php

namespace App\Domain\User;

use App\Infrastructure\Auth\Hashing\BasicPasswordHashing;
use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    private string $password;
    private IPasswordHashing $passwordHashing;

    public function setUp(): void
    {
        $this->password = 'a!@ 123';
        $this->passwordHashing = new BasicPasswordHashing();
    }

    /**
     * @test
     */
    public function shouldCreateAnUserPassword()
    {
        $userPassword = UserPassword::fromPlaneText(
            $this->password,
            $this->passwordHashing
        );
        $this->assertInstanceOf(UserPassword::class, $userPassword);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongUserPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The password entered exceeds the length of 50.");
        $this->expectExceptionCode(422);
        $userPassword = UserPassword::fromPlaneText(
            str_repeat('a', 51),
            $this->passwordHashing
        );
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithAShortUserPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The entered password must have a minimum of 4 characters.");
        $this->expectExceptionCode(422);
        $userPassword = UserPassword::fromPlaneText(
            str_repeat('a', 3),
            $this->passwordHashing
        );
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

    /**
     * @test
     */
    public function shouldBeaValidPassword()
    {
        $userPassword = UserPassword::fromPlaneText(
            $this->password,
            $this->passwordHashing
        );

        $valid = $this->passwordHashing->verify(
            $this->password,
            $userPassword->hash()
        );

        $this->assertEquals(true, $valid);
    }
}