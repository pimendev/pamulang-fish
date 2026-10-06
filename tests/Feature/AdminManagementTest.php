<?php

namespace Tests\Feature;

use App\Models\AppearanceSetting;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_access_and_update_appearance_customizer(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        $this->actingAs($admin)->get('/admin/appearance')
            ->assertStatus(200)
            ->assertSee('Live Appearance');

        $response = $this->actingAs($admin)->post('/admin/appearance', [
            'theme_mode' => 'dark',
            'primary_color' => '#0284c7',
            'secondary_color' => '#059669',
            'accent_color' => '#06b6d4',
            'background_color' => '#0f172a',
            'surface_color' => '#1e293b',
            'text_color' => '#f8fafc',
            'muted_text_color' => '#94a3b8',
            'border_color' => '#334155',
            'font_family' => 'Plus Jakarta Sans',
            'body_font_size' => '15px',
            'heading_font_size' => '30px',
            'button_font_size' => '14px',
            'heading_font_weight' => '700',
            'body_font_weight' => '400',
            'border_radius' => '12px',
            'button_style' => 'solid',
            'navbar_style' => 'default',
            'site_title' => 'BETTA STORE PAMULANG',
            'site_tagline' => 'Spesialis Ikan Cupang Hias Dinamis',
            'whatsapp_number' => '628999888777',
            'announcement_active' => '1',
            'announcement_text' => 'Diskon Kilat Cupang Hias!',
            'hero_title' => 'Koleksi Terbaik Cupang Hias',
        ]);

        $response->assertRedirect('/admin/appearance');

        $setting = AppearanceSetting::current();
        $this->assertEquals('dark', $setting->theme_mode);
        $this->assertEquals('#0f172a', $setting->background_color);
        $this->assertEquals('BETTA STORE PAMULANG', $setting->site_title);
        $this->assertEquals('Diskon Kilat Cupang Hias!', $setting->announcement_text);
    }

    public function test_admin_can_crud_betta_categories(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        // Create category
        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Cupang Big Ear Lavender',
            'description' => 'Varietas cupang telinga lebar berwarna lavender',
            'icon' => 'feather',
            'sort_order' => 9,
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Cupang Big Ear Lavender']);

        $category = Category::where('name', 'Cupang Big Ear Lavender')->first();

        // Update category
        $this->actingAs($admin)->put("/admin/categories/{$category->id}", [
            'name' => 'Cupang Big Ear Lavender Super',
            'description' => 'Updated deskripsi',
            'icon' => 'feather',
            'sort_order' => 9,
        ]);

        $this->assertDatabaseHas('categories', ['name' => 'Cupang Big Ear Lavender Super']);

        // Delete category
        $this->actingAs($admin)->delete("/admin/categories/{$category->id}");
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_crud_products_and_duplicate(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $category = Category::first();

        // Create Product
        $response = $this->actingAs($admin)->post('/admin/products', [
            'category_id' => $category->id,
            'name' => 'Cupang Plakat Red Dragon High Quality',
            'sku' => 'PK-RD-TEST-99',
            'price' => 300000,
            'discount_price' => 250000,
            'stock' => 2,
            'status' => 'available',
            'gender' => 'male',
            'betta_type' => 'plakat',
            'color_pattern' => 'Red Dragon Scales',
            'size_cm' => 4.8,
            'age_months' => 4.0,
            'care_level' => 'intermediate',
            'description' => 'Cupang sisik naga merah tebal',
            'care_guide' => 'Soliter 15x15x20 cm',
            'is_featured' => 1,
        ]);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', ['sku' => 'PK-RD-TEST-99']);

        $product = Product::where('sku', 'PK-RD-TEST-99')->first();

        // Duplicate
        $dupResponse = $this->actingAs($admin)->post("/admin/products/{$product->id}/duplicate");
        $dupResponse->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', ['name' => 'Cupang Plakat Red Dragon High Quality (Salinan)']);
    }

    public function test_admin_can_update_order_status_and_export_reports(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@pamulangfish.com',
            'customer_phone' => '081122334455',
            'shipping_province' => 'Jawa Barat',
            'shipping_city' => 'Depok',
            'shipping_district' => 'Cinere',
            'shipping_address' => 'Jl. Cinere Raya No. 4',
            'shipping_postal_code' => '16514',
            'shipping_courier' => 'JNE YES',
            'special_live_fish_packing' => true,
            'subtotal' => 250000,
            'shipping_cost' => 60000,
            'discount' => 0,
            'total_amount' => 310000,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending',
            'order_status' => 'received',
        ]);

        // Update order status
        $this->actingAs($admin)->put("/admin/orders/{$order->id}/status", [
            'payment_status' => 'paid',
            'order_status' => 'shipped',
            'tracking_number' => 'JNE-YES-998877',
            'notes' => 'Ikan telah dipuasakan dan dikemas oksigen.',
        ]);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('shipped', $order->order_status);
        $this->assertEquals('JNE-YES-998877', $order->tracking_number);

        // Reports page and CSV export
        $this->actingAs($admin)->get('/admin/reports')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/reports/export-csv')->assertStatus(200);
    }
}
