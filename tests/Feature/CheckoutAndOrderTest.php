<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAndOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_customer_can_checkout_live_fish_order_successfully(): void
    {
        $product = Product::where('status', 'available')->where('stock', '>', 0)->first();
        $customer = User::where('role', 'customer')->first();

        // Add to cart
        $this->actingAs($customer)->post("/cart/add/{$product->id}", ['quantity' => 1]);

        // Access checkout
        $this->get('/checkout')->assertStatus(200)->assertSee('Checkout Pengiriman Hewan Hidup');

        // Process order
        $response = $this->post('/checkout', [
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'customer@pamulangfish.com',
            'customer_phone' => '081234567890',
            'shipping_province' => 'Banten',
            'shipping_city' => 'Tangerang Selatan',
            'shipping_district' => 'Pamulang',
            'shipping_address' => 'Jl. Pajajaran No. 12',
            'shipping_postal_code' => '15417',
            'shipping_courier' => 'JNE YES + Oksigen',
            'payment_method' => 'bank_transfer',
            'notes' => 'Tolong berikan daun ketapang ekstra',
        ]);

        $order = Order::latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('Budi Santoso', $order->customer_name);
        $this->assertEquals('received', $order->order_status);
        $this->assertTrue($order->special_live_fish_packing);

        $response->assertRedirect("/orders/{$order->order_number}");

        // View order details
        $orderPage = $this->get("/orders/{$order->order_number}");
        $orderPage->assertStatus(200);
        $orderPage->assertSee($order->order_number);
        $orderPage->assertSee('Tahapan Live Tracking Pengiriman Ikan Hidup');

        // Confirm payment
        $confirmResponse = $this->post("/orders/{$order->order_number}/confirm-payment");
        $confirmResponse->assertRedirect("/orders/{$order->order_number}");

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('payment_confirmed', $order->order_status);
    }

    public function test_public_tracking_page_can_find_order_by_number(): void
    {
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => 'Ahmad Cupang',
            'customer_email' => 'ahmad@example.com',
            'customer_phone' => '089988776655',
            'shipping_province' => 'DKI Jakarta',
            'shipping_city' => 'Jakarta Selatan',
            'shipping_district' => 'Kebon Jeruk',
            'shipping_address' => 'Jl. Anggrek No. 10',
            'shipping_postal_code' => '11530',
            'shipping_courier' => 'TIKI ONS',
            'special_live_fish_packing' => true,
            'subtotal' => 200000,
            'shipping_cost' => 60000,
            'discount' => 0,
            'total_amount' => 260000,
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'order_status' => 'fish_preparation',
            'tracking_number' => 'TIKI-889900',
        ]);

        $response = $this->get('/tracking?order_number='.$order->order_number);

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
        $response->assertSee('Ahmad Cupang');
        $response->assertSee('TIKI-889900');
    }
}
