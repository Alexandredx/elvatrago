<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ClickLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Create Default Users (Admin & Customer)
        User::firstOrCreate(
            ['email' => 'admin@globalclick.com'],
            [
                'name' => 'Administrador GlobalClick',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente@globalclick.com'],
            [
                'name' => 'Cliente GlobalClick',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 1. Create Categories
        $tech = Category::create([
            'name' => 'Electrónica & Gadgets',
            'slug' => 'electronica-gadgets',
            'description' => 'Dispositivos inteligentes, periféricos y accesorios de última tecnología.',
            'icon' => 'laptop'
        ]);

        $audio = Category::create([
            'name' => 'Audio & Sonido Premium',
            'slug' => 'audio-sonido-premium',
            'description' => 'Auriculares inalámbricos, altavoces Bluetooth y equipos de sonido hi-fi.',
            'icon' => 'headphones'
        ]);

        $fashion = Category::create([
            'name' => 'Moda & Accesorios',
            'slug' => 'moda-accesorios',
            'description' => 'Relojes inteligentes, gafas, ropa de tendencia y estilo personal.',
            'icon' => 'watch'
        ]);

        $home = Category::create([
            'name' => 'Hogar & Smart Living',
            'slug' => 'hogar-smart-living',
            'description' => 'Iluminación ambiental RGB, gadgets para casa inteligente y confort.',
            'icon' => 'home'
        ]);

        // 2. Create Direct Sales Products (Shopify-Style)
        $p1 = Product::create([
            'category_id' => $audio->id,
            'title' => 'Auriculares Inalámbricos SoundPulse Pro ANC',
            'slug' => 'auriculares-inalambricos-soundpulse-pro-anc',
            'short_description' => 'Cancelación activa de ruido, 36 horas de batería y micrófono ultra nítido.',
            'description' => 'Los Auriculares SoundPulse Pro ANC ofrecen una experiencia de sonido envolvente de alta fidelidad. Cuentan con cancelación activa de ruido adaptativa (ANC), almohadillas de espuma viscoelástica transpirable y conexión Bluetooth 5.3 ultra rápida.',
            'price' => 129.99,
            'sale_price' => 89.99,
            'type' => 'direct',
            'stock' => 25,
            'is_featured' => true,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p1->id, 'image_path' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);
        ProductImage::create(['product_id' => $p1->id, 'image_path' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=800&q=80', 'is_primary' => false, 'sort_order' => 2]);
        ProductImage::create(['product_id' => $p1->id, 'image_path' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=800&q=80', 'is_primary' => false, 'sort_order' => 3]);

        $p2 = Product::create([
            'category_id' => $fashion->id,
            'title' => 'Smartwatch Ultra Horizon Amoled Edition',
            'slug' => 'smartwatch-ultra-horizon-amoled-edition',
            'short_description' => 'Pantalla AMOLED 2.0", medición de SpO2, ritmo cardíaco y GPS integrado.',
            'description' => 'Diseño premium en titanio aeroespacial. El Smartwatch Ultra Horizon te acompaña en cada entrenamiento y monitorea tu salud las 24 horas del día. Resistente al agua 5 ATM y con autonomía de hasta 12 días.',
            'price' => 199.00,
            'sale_price' => 149.50,
            'type' => 'direct',
            'stock' => 14,
            'is_featured' => true,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p2->id, 'image_path' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);
        ProductImage::create(['product_id' => $p2->id, 'image_path' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&q=80', 'is_primary' => false, 'sort_order' => 2]);

        $p3 = Product::create([
            'category_id' => $tech->id,
            'title' => 'Teclado Mecánico RGB Custom Wireless 75%',
            'slug' => 'teclado-mecanico-rgb-custom-wireless-75',
            'short_description' => 'Switches mecánicos lubricados de fábrica, construcción Gasket Mount y Hot-Swap.',
            'description' => 'Experimenta una sensación táctil acústica inigualable con nuestro teclado custom inalámbrico de formato 75%. Compatible con Windows y macOS, con triple modo de conexión (Bluetooth, 2.4Ghz y USB-C).',
            'price' => 110.00,
            'sale_price' => null,
            'type' => 'direct',
            'stock' => 8,
            'is_featured' => false,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p3->id, 'image_path' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);

        // Sample Direct Order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => 'Carlos Mendoza',
            'customer_email' => 'carlos.mendoza@example.com',
            'customer_phone' => '+51 987654321',
            'shipping_address' => 'Av. Javier Prado Este 1234, Dpto 502, Lima',
            'total_amount' => 89.99,
            'status' => 'completed',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p1->id,
            'product_title' => $p1->title,
            'quantity' => 1,
            'price' => 89.99,
        ]);
    }
}
