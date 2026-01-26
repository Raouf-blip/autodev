<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    private Wallet $wallet;

    protected function setUp(): void
    {
        $this->wallet = new Wallet('EUR');
    }

    /**
     * @dataProvider validCurrenciesProvider
     */
    public function testConstructorWithValidCurrency(string $currency): void
    {
        $wallet = new Wallet($currency);
        $this->assertEquals($currency, $wallet->getCurrency());
        $this->assertEquals(0, $wallet->getBalance());
    }

    public static function validCurrenciesProvider(): array
    {
        return [
            ['EUR'],
            ['USD'],
        ];
    }

    public function testConstructorWithInvalidCurrency(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        new Wallet('GBP');
    }

    /**
     * @dataProvider validBalancesProvider
     */
    public function testSetBalance(float $balance): void
    {
        $this->wallet->setBalance($balance);
        $this->assertEquals($balance, $this->wallet->getBalance());
    }

    public static function validBalancesProvider(): array
    {
        return [
            [0],
            [10.5],
            [100],
            [1000.99],
        ];
    }

    public function testSetNegativeBalance(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid balance');
        $this->wallet->setBalance(-10);
    }

    /**
     * @dataProvider validAmountsProvider
     */
    public function testAddFund(float $amount): void
    {
        $this->wallet->setBalance(100);
        $this->wallet->addFund($amount);
        $this->assertEquals(100 + $amount, $this->wallet->getBalance());
    }

    public static function validAmountsProvider(): array
    {
        return [
            [10],
            [0.5],
            [999.99],
        ];
    }

    public function testAddNegativeFund(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $this->wallet->addFund(-5);
    }

    /**
     * @dataProvider validWithdrawalsProvider
     */
    public function testRemoveFund(float $balance, float $amount): void
    {
        $this->wallet->setBalance($balance);
        $this->wallet->removeFund($amount);
        $this->assertEquals($balance - $amount, $this->wallet->getBalance());
    }

    public static function validWithdrawalsProvider(): array
    {
        return [
            [100, 50],
            [100, 100],
            [100, 0],
            [50.75, 25.50],
        ];
    }

    public function testRemoveNegativeFund(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        $this->wallet->removeFund(-5);
    }

    public function testRemoveFundInsufficientBalance(): void
    {
        $this->wallet->setBalance(50);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');
        $this->wallet->removeFund(100);
    }

    public function testGetBalance(): void
    {
        $this->assertEquals(0, $this->wallet->getBalance());
        $this->wallet->setBalance(42.50);
        $this->assertEquals(42.50, $this->wallet->getBalance());
    }

    public function testGetCurrency(): void
    {
        $this->assertEquals('EUR', $this->wallet->getCurrency());
    }

    public function testAvailableCurrencyConstant(): void
    {
        $this->assertContains('USD', Wallet::AVAILABLE_CURRENCY);
        $this->assertContains('EUR', Wallet::AVAILABLE_CURRENCY);
        $this->assertCount(2, Wallet::AVAILABLE_CURRENCY);
    }

    public function testSetCurrencyWithValidCurrency(): void
    {
        $this->wallet->setCurrency('USD');
        $this->assertEquals('USD', $this->wallet->getCurrency());
    }

    public function testSetCurrencyWithInvalidCurrency(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $this->wallet->setCurrency('GBP');
    }
}
