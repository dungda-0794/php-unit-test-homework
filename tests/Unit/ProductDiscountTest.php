<?php

namespace Tests\Unit;

use Modules\Exercise03\Services\ProductService;
use Modules\Exercise03\Models\Product;
use Tests\TestCase;

class ProductDiscountTest extends TestCase
{
    private $productService;

    public function setUp(): void
    {
        parent::setUp();
        $this->productService = new ProductService();
    }

    /**
     * All products is other type and total < 7 test
     *
     * @return void
     */
    public function testProductOthersAndLessThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::OTHER_TYPE, 3);
        
        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(0, $discount);
    }

    /**
     * All products is other type and total = 7 test
     *
     * @return void
     */
    public function testProductOthersAndEqualsToSevenTest()
    {
        $products = $this->createProductsbyType(Product::OTHER_TYPE, 7);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     * All products is other type and total > 7 test
     *
     * @return void
     */
    public function testProductOthersAndGreaterThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::OTHER_TYPE, 8);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     * All products is white shirt type and total < 7 test
     *
     * @return void
     */
    public function testProductWhiteShirtAndLessThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::WHITE_SHIRT_TYPE, 3);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(0, $discount);
    }

    /**
     * All products is white shirt type and total = 7 test
     *
     * @return void
     */
    public function testProductWhiteShirtAndEqualsToSevenTest()
    {
        $products = $this->createProductsbyType(Product::WHITE_SHIRT_TYPE, 7);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     * All products is white shirt type and total > 7 test
     *
     * @return void
     */
    public function testProductWhiteShirtAndGreaterThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::WHITE_SHIRT_TYPE, 8);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     * All products is cravat type and total < 7 test
     *
     * @return void
     */
    public function testProductCravatAndLessThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::CRAVAT_TYPE, 3);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(0, $discount);
    }

    /**
     * All products is cravat type and total = 7 test
     *
     * @return void
     */
    public function testProductCravatAndEqualsToSevenTest()
    {
        $products = $this->createProductsbyType(Product::CRAVAT_TYPE, 7);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     * All products is cravat type and total = 7 test
     *
     * @return void
     */
    public function testProductCravatAndGreaterThanSevenTest()
    {
        $products = $this->createProductsbyType(Product::CRAVAT_TYPE, 8);

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(7, $discount);
    }

    /**
     *  There are both product types and total > 7 test
     *
     * @return void
     */
    public function testBothProductTypesAndLessThanSevenTest()
    {
        $products = [
            Product::CRAVAT_TYPE => [
                'Cravat 1',
                'Cravat 2',
            ],
            Product::WHITE_SHIRT_TYPE => [
                'White shirt 1',
                'White shirt 2',
            ],
            Product::OTHER_TYPE => [
                'Product other 1',
                'Product other 2',
            ]
        ];

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(5, $discount);
    }

    /**
     * There are both product types and total = 7 test
     *
     * @return void
     */
    public function testBothProductTypesAndEqualsToSevenTest()
    {
        $products = [
            Product::CRAVAT_TYPE => [
                'Cravat 1',
                'Cravat 2',
                'Cravat 3',
            ],
            Product::WHITE_SHIRT_TYPE => [
                'White shirt 1',
                'White shirt 2',
            ],
            Product::OTHER_TYPE => [
                'Product other 1',
                'Product other 2',
            ]
        ];

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(12, $discount);
    }

    /**
     * There are both product types and total > 7 test
     *
     * @return void
     */
    public function testBothProductTypesAndGreaterThanSevenTest()
    {
        $products = [
            Product::CRAVAT_TYPE => [
                'Cravat 1',
                'Cravat 2',
                'Cravat 3',
            ],
            Product::WHITE_SHIRT_TYPE => [
                'White shirt 1',
                'White shirt 2',
                'White shirt 3',
            ],
            Product::OTHER_TYPE => [
                'Product other 1',
                'Product other 2',
            ]
        ];

        $discount = $this->productService->calculateDiscount($products);

        $this->assertEquals(12, $discount);
    }

    private function createProductsbyType($type, $productCount)
    {
        $productNames = [
            Product::CRAVAT_TYPE => 'Cravat',
            Product::WHITE_SHIRT_TYPE => 'White shirt',
            Product::OTHER_TYPE => 'Product other',
        ];

        $products = [];
        for ($i = 0; $i < $productCount; $i++) { 
            $products[] = $productNames[$type] .' '. ($i + 1);
        }

        return [
            $type => $products
        ];
    }
}
