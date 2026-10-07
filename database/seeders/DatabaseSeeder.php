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
            ['email' => 'admin@elvatrago.com'],
            [
                'name' => 'Administrador Elvatrago',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'cliente@elvatrago.com'],
            [
                'name' => 'Cliente Ejemplo',
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

        // 3. Create External Redirect Products (Affiliate Style)
        $p4 = Product::create([
            'category_id' => $tech->id,
            'title' => 'Cámara de Seguridad Portátil Mini WiFi HD',
            'slug' => 'camara-de-seguridad-portatil-mini-wifi-hd',
            'short_description' => 'Lente gran angular 1080p, visión nocturna infrarroja y detector de movimiento.',
            'description' => 'Redirección oficial a la tienda verificada. Consigue esta mini cámara de seguridad con visión nocturna y transmisión en vivo directamente a tu smartphone.',
            'price' => 35.00,
            'sale_price' => 14.99,
            'type' => 'affiliate',
            'external_url' => 'https://ejemplo.com/?aff_platform=default&sk=example_token',
            'platform_name' => 'affiliate',
            'stock' => 0,
            'is_featured' => true,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p4->id, 'image_path' => 'https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);
        ProductImage::create(['product_id' => $p4->id, 'image_path' => 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?auto=format&fit=crop&w=800&q=80', 'is_primary' => false, 'sort_order' => 2]);

        $p5 = Product::create([
            'category_id' => $home->id,
            'title' => 'Lámpara Barra LED RGB para Monitor Smart',
            'slug' => 'lampara-barra-led-rgb-para-monitor-smart',
            'short_description' => 'Sin reflejo en pantalla, luz cálida/fría ajustable y sincronización musical.',
            'description' => 'Producto disponible directamente en tienda asociada. Ideal para mejorar la iluminación de tu escritorio y reducir la fatiga visual durante largas sesiones de trabajo o juegos.',
            'price' => 45.00,
            'sale_price' => 18.80,
            'type' => 'affiliate',
            'external_url' => 'https://ejemplo.com/goods.html?_bg_fs=1&goods_id=example_id',
            'platform_name' => 'partner',
            'stock' => 0,
            'is_featured' => true,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p5->id, 'image_path' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);

        $p6 = Product::create([
            'category_id' => $audio->id,
            'title' => 'Mini Altavoz Bluetooth Impermeable IPX7',
            'slug' => 'mini-altavoz-bluetooth-impermeable-ipx7',
            'short_description' => 'Bajos potentes, mosquetón de transporte y resistencia total al agua.',
            'description' => 'Consigue el mini altavoz portátil más vendido a precio directo de fábrica. Conexión rápida y diseño resistente.',
            'price' => 28.00,
            'sale_price' => 12.50,
            'type' => 'affiliate',
            'external_url' => 'https://ejemplo.com/?item=mini_speaker_deal',
            'platform_name' => 'affiliate',
            'stock' => 0,
            'is_featured' => false,
            'is_active' => true,
        ]);
        ProductImage::create(['product_id' => $p6->id, 'image_path' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=800&q=80', 'is_primary' => true, 'sort_order' => 1]);

        // 4. Sample Click Logs
        ClickLog::create(['product_id' => $p4->id, 'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0)', 'referer' => 'http://localhost/']);
        ClickLog::create(['product_id' => $p4->id, 'ip_address' => '192.168.1.50', 'user_agent' => 'Mozilla/5.0 (iPhone)', 'referer' => 'http://localhost/products/camara-de-seguridad-portatil-mini-wifi-hd']);
        ClickLog::create(['product_id' => $p5->id, 'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0)', 'referer' => 'http://localhost/']);

        // 5. Sample Direct Order
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
