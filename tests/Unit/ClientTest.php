<?php


namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;


class ClientTest extends TestCase
{
    private Client $client;

    protected function setUp(): void {
        parent::setUp();
        $this->client = new Client;
    }

    public function testGetName(): void {
        $value = 'testname';
        $response = $this->client->setName($value);

        self::assertInstanceOf(Client::class, $response);
        self::assertEquals($value, $this->client->getName());
    }

    public function testGetUsers(): void {
        $value = new User();

        $response = $this->client->addUser($value);

        self::assertInstanceOf(Client::class, $response);
        self::assertCount(1, $this->client->getUsers());
        self::assertTrue($this->client->getUsers()->contains($value));
    }

    public function testDeleteUsers(): void {
        $value = new User();
        $value0 = new User();

        $response = $this->client->addUser($value);
        $response0 = $this->client->addUser($value0);

        self::assertInstanceOf(Client::class, $response);
        self::assertInstanceOf(Client::class, $response0);
        self::assertCount(2, $this->client->getUsers());
        self::assertTrue($this->client->getUsers()->contains($value));
        self::assertTrue($this->client->getUsers()->contains($value0));

        $response1 = $this->client->removeUser($value);

        self::assertInstanceOf(Client::class, $response1);
        self::assertCount(1, $this->client->getUsers());
        self::assertTrue($this->client->getUsers()->contains($value0));
        self::assertFalse($this->client->getUsers()->contains($value));
    }
}