<?php

namespace Modules\Exercise03\Services;

use InvalidArgumentException;
use Modules\Exercise03\Models\Product;

/**
 * Class ProductService
 * @package Modules\Exercise03\Services
 */
class ProductService
{
    const CRAVAT_WHITE_SHIRT_DISCOUNT = 5;
    const QUANTITY_DISCOUNT = 7;
    const TOTAL_PRODUCT_TO_DISCOUNT = 7;

    /**
     * Calculate discount by products
     *
     * @param $totalProducts
     * @return mixed
     */
    public function calculateDiscount($products)
    {
        $cravats = isset($products[Product::CRAVAT_TYPE]) ? $products[Product::CRAVAT_TYPE] : [];
        $whiteShirts = isset($products[Product::WHITE_SHIRT_TYPE]) ? $products[Product::WHITE_SHIRT_TYPE] : [];
        $others = isset($products[Product::OTHER_TYPE]) ? $products[Product::OTHER_TYPE] : [];
        $discount = 0;

        $totalProducts = count($cravats) + count($whiteShirts) + count($others);

        if ($totalProducts >= 7) {
            $discount = self::TOTAL_PRODUCT_TO_DISCOUNT;
        }

        if (count($whiteShirts) > 0 && count($cravats) > 0) {
            $discount += self::CRAVAT_WHITE_SHIRT_DISCOUNT;
        }

        return $discount;
    }
}
