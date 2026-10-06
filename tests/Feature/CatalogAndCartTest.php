<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAndCartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_catalog_page_is_accessible_and_lists_betta_specimens(): void
    {
        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertSee('Katalog Spesimen Ikan Cupang');
        $response->assertSee('Filter Katalog');
    }

    public function test_catalog_can_be_filtered_by_betta_type(): void
    {
        $response = $this->get('/catalog?type=halfmoon');

        $response->assertStatus(200);
        $response->assertSee('halfmoon');
    }

    public function test_catalog_can_be_sorted_by_top_right_options(): void
    {
        // Terkait
        $resTerkait = $this->get('/catalog?sort=terkait');
        $resTerkait->assertStatus(200);
        $resTerkait->assertSee('Terkait');

        // Terbaru
        $resLatest = $this->get('/catalog?sort=terbaru');
        $resLatest->assertStatus(200);
        $resLatest->assertSee('Terbaru');

        // Terlaris
        $resPopular = $this->get('/catalog?sort=terlaris');
        $resPopular->assertStatus(200);
        $resPopular->assertSee('Terlaris');

        // Harga: Rendah ke Tinggi
        $resLow = $this->get('/catalog?sort=harga_terendah');
        $resLow->assertStatus(200);
        $resLow->assertSee('Harga: Rendah ke Tinggi');

        // Harga: Tinggi ke Rendah
        $resHigh = $this->get('/catalog?sort=harga_tertinggi');
        $resHigh->assertStatus(200);
        $resHigh->assertSee('Harga: Tinggi ke Rendah');
    }

    public function test_catalog_can_be_filtered_by_gender(): void
    {
        $responseFemale = $this->get('/catalog?gender=female');
        $responseFemale->assertStatus(200);
        $responseFemale->assertSee('Betina (Female)');

        $responseMale = $this->get('/catalog?gender=male');
        $responseMale->assertStatus(200);
        $responseMale->assertSee('Jantan (Male)');
    }

    public function test_catalog_handles_category_and_type_filter_combinations(): void
    {
        // Crowntail Female
        $res = $this->get('/catalog?category=crowntail&gender=female');
        $res->assertStatus(200);
        $res->assertSee('Crowntail');

        // Cross-type resilient search
        $resCross = $this->get('/catalog?category=crowntail&type=plakat');
        $resCross->assertStatus(200);
    }

    public function test_soliter_showcase_product_detail_page_loads_correctly(): void
    {
        $product = Product::first();

        $response = $this->get('/cupang/'.$product->slug);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('Spesifikasi Fisik Spesimen');
        $response->assertSee('WYSIWYG');
        $response->assertSee('Death on Arrival');
    }

    public function test_customer_can_add_betta_fish_to_cart_and_view_cart(): void
    {
        $product = Product::where('status', 'available')->where('stock', '>', 0)->first();

        $response = $this->post("/cart/add/{$product->id}", [
            'quantity' => 1,
        ]);

        $response->assertRedirect('/cart');

        $cartResponse = $this->get('/cart');
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($product->name);
        $cartResponse->assertSee('Packing Tabung Oksigen');
    }

    public function test_customer_can_update_quantity_and_remove_from_cart(): void
    {
        $product = Product::where('status', 'available')->where('stock', '>=', 2)->first();

        $this->post("/cart/add/{$product->id}", ['quantity' => 1]);

        $this->put("/cart/update/{$product->id}", ['quantity' => 2]);
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);

        $this->delete("/cart/remove/{$product->id}");
        $this->assertArrayNotHasKey($product->id, session('cart', []));
    }
}
