<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleAndWishlistTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_articles_index_and_detail_are_accessible_with_cross_selling(): void
    {
        $response = $this->get('/articles');
        $response->assertStatus(200);
        $response->assertSee('Panduan Perawatan Ikan Cupang Hias');

        $article = Article::first();
        $detailResponse = $this->get('/articles/'.$article->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($article->title);
    }

    public function test_customer_can_toggle_wishlist(): void
    {
        $product = Product::first();
        $customer = User::where('role', 'customer')->first();

        // Toggle add to wishlist
        $response = $this->actingAs($customer)->post("/wishlist/toggle/{$product->id}");
        $response->assertSessionHas('success');

        $wishlistPage = $this->get('/wishlist');
        $wishlistPage->assertStatus(200);
        $wishlistPage->assertSee($product->name);

        // Toggle remove from wishlist
        $this->actingAs($customer)->post("/wishlist/toggle/{$product->id}");
        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
        ]);
    }
}
