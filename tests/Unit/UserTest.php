<?php


namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = new User();

    }

    public function testGetUsername(): void {
        $value = 'testusername';
        $response = $this->user->setUsername($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $this->user->getUsername());
    }

    public function testGetRoles(): void {
        $value = ['ROLE_ADMIN'];

        $response = $this->user->setRoles($value);

        self::assertInstanceOf(User::class, $response);
        self::assertContains('ROLE_USER', $this->user->getRoles());
        self::assertContains('ROLE_ADMIN', $this->user->getRoles());
    }

    public function testGetPassword(): void {
        $value = 'perenoel';

        $response = $this->user->setPassword($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $this->user->getPassword());
    }
}