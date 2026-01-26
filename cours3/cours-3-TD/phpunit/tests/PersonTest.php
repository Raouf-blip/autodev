<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    private Person $person;
    private Person $person2;

    protected function setUp(): void
    {
        $this->person = new Person('John Doe', 'EUR');
        $this->person2 = new Person('Jane Smith', 'EUR');
    }

    public function testConstructor(): void
    {
        $person = new Person('Alice', 'USD');
        $this->assertEquals('Alice', $person->getName());
        $this->assertInstanceOf(Wallet::class, $person->getWallet());
        $this->assertEquals('USD', $person->getWallet()->getCurrency());
    }

    public function testGetName(): void
    {
        $this->assertEquals('John Doe', $this->person->getName());
    }

    public function testSetName(): void
    {
        $this->person->setName('Jane Doe');
        $this->assertEquals('Jane Doe', $this->person->getName());
    }

    public function testGetWallet(): void
    {
        $this->assertInstanceOf(Wallet::class, $this->person->getWallet());
        $this->assertEquals('EUR', $this->person->getWallet()->getCurrency());
    }

    public function testSetWallet(): void
    {
        $newWallet = new Wallet('USD');
        $newWallet->setBalance(50);
        $this->person->setWallet($newWallet);
        $this->assertEquals('USD', $this->person->getWallet()->getCurrency());
        $this->assertEquals(50, $this->person->getWallet()->getBalance());
    }

    public function testHasFundWithZeroBalance(): void
    {
        $this->assertFalse($this->person->hasFund());
    }

    public function testHasFundWithPositiveBalance(): void
    {
        $this->person->getWallet()->setBalance(100);
        $this->assertTrue($this->person->hasFund());
    }

    public function testTransfertFundSuccessful(): void
    {
        $this->person->getWallet()->setBalance(100);
        $this->person2->getWallet()->setBalance(50);

        $this->person->transfertFund(30, $this->person2);

        $this->assertEquals(70, $this->person->getWallet()->getBalance());
        $this->assertEquals(80, $this->person2->getWallet()->getBalance());
    }

    public function testTransfertFundWithDifferentCurrencies(): void
    {
        $person3 = new Person('Bob', 'USD');
        $this->person->getWallet()->setBalance(100);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t give money with different currencies');
        $this->person->transfertFund(50, $person3);
    }

    /**
     * @dataProvider transfertFundAmountsProvider
     */
    public function testTransfertFundWithVariousAmounts(float $senderBalance, float $amount): void
    {
        $this->person->getWallet()->setBalance($senderBalance);
        $this->person2->getWallet()->setBalance(0);

        $this->person->transfertFund($amount, $this->person2);

        $this->assertEquals($senderBalance - $amount, $this->person->getWallet()->getBalance());
        $this->assertEquals($amount, $this->person2->getWallet()->getBalance());
    }

    public static function transfertFundAmountsProvider(): array
    {
        return [
            [100, 50],
            [100, 100],
            [100, 0.5],
            [50.75, 25.50],
        ];
    }

    public function testDivideWalletEqualParts(): void
    {
        $person3 = new Person('Charlie', 'EUR');
        $this->person->getWallet()->setBalance(100);

        $this->person->divideWallet([$this->person2, $person3]);

        $totalDistributed = $this->person->getWallet()->getBalance() +
                          $this->person2->getWallet()->getBalance() +
                          $person3->getWallet()->getBalance();

        $this->assertEquals(100, $totalDistributed);
    }

    public function testDivideWalletWithDifferentCurrencies(): void
    {
        $person3 = new Person('Charlie', 'USD');
        $this->person->getWallet()->setBalance(100);

        // Only person2 should receive funds (same currency)
        $this->person->divideWallet([$this->person2, $person3]);

        // All funds should go to person2 since person3 has different currency
        $this->assertEquals(0, $this->person->getWallet()->getBalance());
        $this->assertEquals(100, $this->person2->getWallet()->getBalance());
    }

    public function testBuyProductSuccessful(): void
    {
        $product = new Product('Laptop', ['EUR' => 1000], 'tech');
        $this->person->getWallet()->setBalance(1500);

        $this->person->buyProduct($product);

        $this->assertEquals(500, $this->person->getWallet()->getBalance());
    }

    public function testBuyProductWithInsufficientFunds(): void
    {
        $product = new Product('Laptop', ['EUR' => 1000], 'tech');
        $this->person->getWallet()->setBalance(500);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient funds');
        $this->person->buyProduct($product);
    }

    public function testBuyProductWithUnavailableCurrency(): void
    {
        $product = new Product('Laptop', ['USD' => 1000], 'tech');
        $this->person->getWallet()->setBalance(2000);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t buy product with this wallet currency');
        $this->person->buyProduct($product);
    }

    public function testBuyProductMultipleCurrencies(): void
    {
        $product = new Product('Phone', ['EUR' => 500, 'USD' => 600], 'tech');
        $this->person->getWallet()->setBalance(1000);

        $this->person->buyProduct($product);

        $this->assertEquals(500, $this->person->getWallet()->getBalance());
    }
}
