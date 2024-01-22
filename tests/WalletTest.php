<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Wallet;

class WalletTest extends TestCase
{
    public function testAddFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(100);

        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testAddFundInvalidException(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(100);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $wallet->addFund(-150);
    }

    public function testRemoveFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(100);
        $wallet->removeFund(50);

        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testRemoveFundInvalidException(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(100);
    
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $wallet->removeFund(-150);
    }
    
    public function testRemoveFundInsufficientFundsException(): void
    {
        $wallet = new Wallet('USD');
    
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');
        $wallet->removeFund(150);
    }

    public function testGetCurrency(): void
    {
        $wallet = new Wallet('USD');

        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testSetCurrency(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setCurrency('EUR');

        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    public function testSetCurrencyException(): void
    {
        $wallet = new Wallet('USD');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $wallet->setCurrency('JPY');
    }

    public function testGetBalance(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(100);

        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testSetBalance(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);

        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testSetBalanceException(): void
    {
        $wallet = new Wallet('USD');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid balance');
        $wallet->setBalance(-100);
    }
    
   





}