<?php


namespace App\Tests\Unit;

use App\Entity\Client;
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

    public function testClient(): void {
        $value = new Client();

        $response = $value->addUser($this->user);

        self::assertInstanceOf(Client::class, $response);
        self::assertInstanceOf(Client::class, $this->user->getClient());
        self::assertTrue($value->getUsers()->contains($this->user));
        self::assertEquals($this->user->getClient(), $value);
    }
}