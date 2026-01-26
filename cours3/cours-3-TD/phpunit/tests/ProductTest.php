<?php

namespace Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product('Bread', ['EUR' => 2.5, 'USD' => 3], 'food');
    }

    /**
     * @dataProvider validProductTypesProvider
     */
    public function testConstructorWithValidType(string $type): void
    {
        $product = new Product('Test Product', ['EUR' => 10], $type);
        $this->assertEquals($type, $product->getType());
    }

    public static function validProductTypesProvider(): array
    {
        return [
            ['food'],
            ['tech'],
            ['alcohol'],
            ['other'],
        ];
    }

    public function testConstructorWithInvalidType(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid type');
        new Product('Test', ['EUR' => 10], 'invalid');
    }

    public function testGetName(): void
    {
        $this->assertEquals('Bread', $this->product->getName());
    }

    public function testSetName(): void
    {
        $this->product->setName('Croissant');
        $this->assertEquals('Croissant', $this->product->getName());
    }

    public function testGetPrices(): void
    {
        $prices = $this->product->getPrices();
        $this->assertArrayHasKey('EUR', $prices);
        $this->assertArrayHasKey('USD', $prices);
        $this->assertEquals(2.5, $prices['EUR']);
        $this->assertEquals(3, $prices['USD']);
    }

    public function testSetPrices(): void
    {
        $newPrices = ['EUR' => 5, 'USD' => 6];
        $this->product->setPrices($newPrices);
        $this->assertEquals($newPrices, $this->product->getPrices());
    }

    public function testSetPricesWithInvalidCurrency(): void
    {
        $prices = ['EUR' => 10, 'GBP' => 12, 'USD' => 11];
        $this->product->setPrices($prices);
        $productPrices = $this->product->getPrices();

        // GBP should be ignored as it's not in AVAILABLE_CURRENCY
        $this->assertArrayHasKey('EUR', $productPrices);
        $this->assertArrayHasKey('USD', $productPrices);
        $this->assertArrayNotHasKey('GBP', $productPrices);
    }

    public function testSetPricesWithNegativePrice(): void
    {
        $prices = ['EUR' => 10];
        $this->product->setPrices($prices);
        
        $prices = ['EUR' => 10, 'USD' => -5];
        $this->product->setPrices($prices);
        $productPrices = $this->product->getPrices();

        // Negative prices should be ignored
        $this->assertArrayHasKey('EUR', $productPrices);
        $this->assertArrayNotHasKey('USD', $productPrices);
    }

    public function testGetType(): void
    {
        $this->assertEquals('food', $this->product->getType());
    }

    public function testSetType(): void
    {
        $this->product->setType('tech');
        $this->assertEquals('tech', $this->product->getType());
    }

    public function testSetInvalidType(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid type');
        $this->product->setType('invalid_type');
    }

    /**
     * @dataProvider tvaDataProvider
     */
    public function testGetTVA(string $type, float $expectedTVA): void
    {
        $product = new Product('Test', ['EUR' => 10], $type);
        $this->assertEquals($expectedTVA, $product->getTVA());
    }

    public static function tvaDataProvider(): array
    {
        return [
            ['food', 0.1],
            ['tech', 0.2],
            ['alcohol', 0.2],
            ['other', 0.2],
        ];
    }

    public function testListCurrencies(): void
    {
        $currencies = $this->product->listCurrencies();
        $this->assertContains('EUR', $currencies);
        $this->assertContains('USD', $currencies);
        $this->assertCount(2, $currencies);
    }

    public function testListCurrenciesWithSingleCurrency(): void
    {
        $product = new Product('Item', ['EUR' => 15], 'tech');
        $currencies = $product->listCurrencies();
        $this->assertCount(1, $currencies);
        $this->assertContains('EUR', $currencies);
    }

    /**
     * @dataProvider validGetPriceProvider
     */
    public function testGetPrice(string $currency, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->product->getPrice($currency));
    }

    public static function validGetPriceProvider(): array
    {
        return [
            ['EUR', 2.5],
            ['USD', 3],
        ];
    }

    public function testGetPriceWithInvalidCurrency(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $this->product->getPrice('GBP');
    }

    public function testGetPriceWithUnavailableCurrency(): void
    {
        $product = new Product('Coffee', ['EUR' => 5], 'food');
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Currency not available for this product');
        $product->getPrice('USD');
    }

    public function testEmptyPrices(): void
    {
        // Create product with at least one valid price
        $product = new Product('Empty', ['EUR' => 0], 'other');
        
        // Now try to set empty prices
        $product->setPrices([]);
        $this->assertEmpty($product->listCurrencies());
    }

    public function testGetPriceFromEmptyPrices(): void
    {
        // Create product with a price first
        $product = new Product('Coffee', ['EUR' => 5], 'food');
        
        // Try to get a price that doesn't exist
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Currency not available for this product');
        $product->getPrice('USD');
    }
}
