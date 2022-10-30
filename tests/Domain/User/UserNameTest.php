<?php

namespace App\Domain\User;

use PHPUnit\Framework\TestCase;

class UserNameTest extends TestCase
{
    private string $userName;

    public function setUp(): void
    {
        $this->userName = 'Jhon Doe';
    }

    public function shouldCreateAnUserName()
    {
        $userName = new UserName($this->userName);
        $this->assertInstanceOf(UserName::class, $userName);
    }

    /**
     * @test
     */
    public function shouldBeEqual()
    {
        $userName1 = new UserName($this->userName);
        $userName2 = new UserName($this->userName);
        $this->assertEquals(true, $userName1->equals($userName2));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithALongUserName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The name entered exceeds the length of 50.");
        $this->expectExceptionCode(422);
        $userName = new UserName(str_repeat('a', 51));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWithInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The name entered hasn't a valid format.");
        $this->expectExceptionCode(422);
        $userName = new UserName($this->userName.'1');
    }
}