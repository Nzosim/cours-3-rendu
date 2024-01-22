<?php

namespace Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testConstruct(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertInstanceOf(Product::class, $product);
    }

    //Tests Getters

    public function testGetName(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals("Iphone 15", $product->getName());
    }

    public function testGetPrices(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals(["EUR" => 500, "USD" => 505], $product->getPrices());
    }

    public function testGetType(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals("tech", $product->getType());
    }

    //Tests Setters

    public function testSetTypeTrue(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $product->setType("other");
        $this->assertEquals("other", $product->getType());
    }

    public function testSetTypeFalse(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->expectException(\Exception::class);
        $product->setType("carette");
    }

    public function testSetName(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $product->setName("Iphone 15.1");
        $this->assertEquals("Iphone 15.1", $product->getName());
    }

    public function testSetPricesTrue(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $product->setPrices(["EUR" => 600, "USD" => 605]);
        $this->assertEquals(["EUR" => 600, "USD" => 605], $product->getPrices());
    }

    public function testSetPricesFalseCurrency(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $product->setPrices(["WON" => 600, "EUR" => 615]);
        $this->assertEquals(["EUR" => 615, "USD" => 505], $product->getPrices());
    }

    public function testSetPricesFalsePrice(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $product->setPrices(["EUR" => 600, "USD" => -605]);
        $this->assertEquals(["EUR" => 600, "USD" => 505], $product->getPrices());
    }

    public function testTVATrueNotFood(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals(0.2, $product->getTVA());
    }

    public function testTVATrueFood(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "food");
        $this->assertEquals(0.1, $product->getTVA());
    }

    public function testListCurrenciesTrue(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals(["EUR", "USD"], $product->listCurrencies());
    }

    public function testGetPriceTrue(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->assertEquals(500, $product->getPrice("EUR"));
    }

    public function testGetPriceFalseCurrency(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500, "USD" => 505], "tech");
        $this->expectException(\Exception::class);
        $product->getPrice("WON");
    }

    public function testGetPriceFalseCurrencyNotInProduct(): void
    {
        $product = new Product("Iphone 15", ["EUR" => 500], "tech");
        $this->expectException(\Exception::class);
        $product->getPrice("USD");
    }
}
