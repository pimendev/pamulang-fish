<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('PAMULANG');
        $response->assertSee('Khusus Ikan Cupang');
    }

    public function test_all_catalog_products_and_categories_are_exclusively_ikan_cupang(): void
    {
        $this->seed();

        $validBettaTypes = ['halfmoon', 'plakat', 'crowntail', 'double_tail', 'giant'];
        $products = Product::all();

        $this->assertNotEmpty($products);
        foreach ($products as $product) {
            $this->assertContains($product->betta_type, $validBettaTypes, "Product {$product->sku} is not a valid betta type.");
            $this->assertStringContainsString('Cupang', $product->name, "Product {$product->name} does not specify Cupang.");
        }

        $categories = Category::all();
        foreach ($categories as $category) {
            $this->assertStringContainsString('Cupang', $category->name, "Category {$category->name} is not a Cupang category.");
        }
    }
}
