<?php


namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void {
        parent::setUp();
        $this->product = new Product;
    }

    public function testGetName(): void {
        $value = 'testname';
        $response = $this->product->setName($value);

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getName());
    }

    public function testGetBrand(): void {
        $value = 'testbrand';
        $response = $this->product->setBrand($value);

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getBrand());
    }

    public function testGetDescription(): void {
        $value = 'testdescription';
        $response = $this->product->setDescription($value);

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getDescription());
    }

    public function testGetPrice(): void {
        $value = 157.05;
        $response = $this->product->setPrice($value);

        self::assertInstanceOf(Product::class, $response);
        self::assertEquals($value, $this->product->getPrice());
    }
}