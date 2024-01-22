<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;

class PersonTest extends TestCase
{

    public function testConstructor(): void {
        $person = new Person('John Doe', 'EUR');
        $this->assertInstanceOf(Person::class, $person);
    }

    public function testGetName(): void {
        $person = new Person('John Doe', 'EUR');
        $result = $person->getName();
        $this->assertEquals('John Doe', $result);
        $this->assertIsString($result);
    }

    public function testSetName(): void {
        $person = new Person('John Doe', 'EUR');
        $person->setName('Jules');
        $result = $person->getName();
        $this->assertEquals('Jules', $result);
        $this->assertIsString($result);
    }

    public function testGetWallet(): void {
        $person = new Person('John Doe', 'EUR');
        $result = $person->getWallet();
        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals(0, $result->getBalance());
    }

    public function testSetWallet(): void {
        $person = new Person('John Doe', 'EUR');
        $wallet = new Wallet('EUR');
        $wallet->setBalance(100);
        $person->setWallet($wallet);
        $result = $person->getWallet();
        $this->assertInstanceOf(Wallet::class, $result);
        $this->assertEquals(100, $result->getBalance());
    }

    public function testHasFundTrue(): void {
        $person = new Person('John Doe', 'EUR');
        $person->getWallet()->setBalance(100);
        $result = $person->hasFund();
        $this->assertTrue($result);
    }

    public function testHasFundFalse(): void {
        $person = new Person('John Doe', 'EUR');
        $result = $person->hasFund();
        $this->assertFalse($result);
    }

    public function testTransfertFundOk(): void {
        $person1 = new Person('John Doe', 'EUR');
        $person1->getWallet()->setBalance(100);
        $person2 = new Person('Jane Doe', 'EUR');
        $person2->getWallet()->setBalance(100);
        $person1->transfertFund(50, $person2);
        $this->assertEquals(50, $person1->getWallet()->getBalance());
        $this->assertEquals(150, $person2->getWallet()->getBalance());
    }

    public function testTransfertFundNoMoney(): void {
        $person1 = new Person('John Doe', 'EUR');
        $person2 = new Person('Jane Doe', 'EUR');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');
        $person1->transfertFund(50, $person2);
        $this->assertEquals(0, $person1->getWallet()->getBalance());
        $this->assertEquals(0, $person2->getWallet()->getBalance());
    }

    public function testTransfertDifferentMoney(): void {
        $person1 = new Person('John Doe', 'EUR');
        $person1->getWallet()->setBalance(100);
        $person2 = new Person('Jane Doe', 'USD');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t give money with different currencies');
        $person1->transfertFund(50, $person2);
        $this->assertEquals(100, $person1->getWallet()->getBalance());
        $this->assertEquals(0, $person2->getWallet()->getBalance());
    }

    public function testDivideWallet(): void {
        $person1 = new Person('John Doe', 'EUR');
        $person1->getWallet()->setBalance(100);
        $person2 = new Person('Jane Doe', 'EUR');
        $person3 = new Person('Jack Doe', 'EUR');
        $person1->divideWallet([$person2, $person3]);
        $this->assertEquals(0, $person1->getWallet()->getBalance());
        $this->assertEquals(50, $person2->getWallet()->getBalance());
        $this->assertEquals(50, $person3->getWallet()->getBalance());
    }

    public function testBuyProduct(): void {
        $person = new Person('John Doe', 'EUR');
        $product = new Product('Banana', ['EUR' => 1, 'USD' => 1.2], 'food'); 
        $person->getWallet()->setBalance(100);
        $person->buyProduct($product);
        $this->assertEquals(99, $person->getWallet()->getBalance());
    }

    public function testBuyProductNoMoneyCurrency(): void {
        $person = new Person('John Doe', 'USD');
        $product = new Product('Banana', ['EUR' => 1], 'food'); 
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t buy product with this wallet currency');
        $person->buyProduct($product);
        $this->assertEquals(0, $person->getWallet()->getBalance());
    }

}
