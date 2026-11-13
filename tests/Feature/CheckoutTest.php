<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('type')->default('direct');
            $table->text('external_url')->nullable();
            $table->string('platform_name')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('has_sizes')->default(false);
            $table->string('size_type')->nullable();
            $table->text('sizes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('por_coordinar');
            $table->string('payment_reference')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('status')->default('confirmed');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_title');
            $table->string('size')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function test_checkout_registers_order_without_payment_gateway(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Bebidas', 'slug' => 'bebidas']);
        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'Pisco Quebranta',
            'slug' => 'pisco-quebranta',
            'price' => 20.00,
            'type' => 'direct',
            'stock' => 10,
            'is_active' => true,
        ]);

        $cart = [
            $product->id => [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => 20.00,
                'quantity' => 2,
                'image' => 'https://example.com/img.jpg',
            ],
        ];

        $indexRes = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->get(route('checkout.index'));

        $indexRes->assertOk();
        $indexRes->assertDontSee('Pasarela de Pago');
        $indexRes->assertDontSee('card_number');
        $indexRes->assertDontSee('izipay');

        $processRes = $this->actingAs($user)
            ->withSession(['cart' => $cart, 'currency' => 'PEN'])
            ->post(route('checkout.process'), [
                'customer_name' => 'Carlos Ruiz',
                'customer_email' => 'carlos@example.com',
                'customer_phone' => '987654321',
                'shipping_address' => 'Av. Arequipa 123, Lima',
                'terms' => 1,
            ]);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertSame('por_coordinar', $order->payment_method);
        $this->assertNull($order->payment_id);
        $this->assertSame(150.0, (float) $order->total_amount);
        $this->assertSame(8, $product->fresh()->stock);
        $this->assertEmpty(session('cart'));

        $processRes->assertRedirect(route('checkout.success', $order->order_number));

        $successRes = $this->actingAs($user)->get(route('checkout.success', $order->order_number));
        $successRes->assertOk();
        $successRes->assertSee('Por coordinar');
    }
}

