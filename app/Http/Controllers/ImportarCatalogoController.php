<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportarCatalogoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Expanded Curated Catalog Dataset of Trending AliExpress & Temu Products
        $externalCatalog = [
            // ==========================================
            // ALIEXPRESS PRODUCTS (25 Items)
            // ==========================================
            [
                'external_id' => 'ali_001',
                'title' => 'Proyector Portátil Mini LED 4K Android Smart WiFi',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 42.00,
                'price' => 89.99,
                'sale_price' => 54.90,
                'external_url' => 'https://best.aliexpress.com/item/1005006123456.html',
                'image_url' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Proyector compacto con resolución 1080p nativa, soporte 4K, WiFi 6 y Bluetooth integrados.',
                'description' => 'Disfruta del cine en casa con este proyector portátil inteligente. Incluye sistema Android para transmitir directamente YouTube, Netflix y Prime Video sin dispositivos adicionales. Pantalla proyectable de hasta 130 pulgadas.',
            ],
            [
                'external_id' => 'ali_002',
                'title' => 'Auriculares Gamer Inalámbricos TWS Latencia Ultra Baja',
                'category_slug' => 'audio-sonido-premium',
                'platform_name' => 'aliexpress',
                'supplier_price' => 8.50,
                'price' => 29.90,
                'sale_price' => 15.99,
                'external_url' => 'https://best.aliexpress.com/item/1005007891011.html',
                'image_url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Luces RGB dinámicas, micrófono dual estéreo y 45ms de latencia para juegos competitivos.',
                'description' => 'Diseñados para los gamers más exigentes. Estos auriculares ofrecen una conexión Bluetooth 5.3 sin retraso de audio y luces LED dinámicas que se ajustan al estilo del estuche de carga.',
            ],
            [
                'external_id' => 'ali_003',
                'title' => 'Reloj Inteligente Militar Impermeable IP68 con Llamadas Bluetooth',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'aliexpress',
                'supplier_price' => 16.00,
                'price' => 49.99,
                'sale_price' => 27.50,
                'external_url' => 'https://best.aliexpress.com/item/1005009988776.html',
                'image_url' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Cuerpo ultra resistente antichoque, medición de presión arterial y 100+ modos deportivos.',
                'description' => 'El reloj inteligente perfecto para actividades extremas. Pantalla HD de 1.96", batería de 400 mAh para más de 10 días de uso continuo y compatibilidad total con iOS y Android.',
            ],
            [
                'external_id' => 'ali_004',
                'title' => 'Tira de Luz LED RGB Neon Flexible Tuya Smart WiFi 5M',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 11.20,
                'price' => 34.00,
                'sale_price' => 19.99,
                'external_url' => 'https://best.aliexpress.com/item/1005004433221.html',
                'image_url' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Sincronización con música, control por voz (Alexa / Google Assistant) y resina de silicona impermeable.',
                'description' => 'Crea ambientes espectaculares en tu habitación o setup de juego. La manguera de neón flexible permite doblarla en cualquier forma y sincronizar sus colores con tus canciones favoritas.',
            ],
            [
                'external_id' => 'ali_005',
                'title' => 'Drone Profesional 4K HD con GPS y Evitación de Obstáculos',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 38.00,
                'price' => 99.00,
                'sale_price' => 59.99,
                'external_url' => 'https://best.aliexpress.com/item/1005008877665.html',
                'image_url' => 'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Cámara doble 4K con estabilizador cardán, retorno automático por GPS y 25 min de vuelo.',
                'description' => 'Captura tomas aéreas impresionantes. Cuenta con sensores de evitación de obstáculos de 360°, seguimiento de objetivos en tiempo real y transmisión FPV HD directamente a tu teléfono.',
            ],
            [
                'external_id' => 'ali_006',
                'title' => 'Consola de Juegos Retro Portátil HD 10.000+ Juegos Integrados',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 18.50,
                'price' => 45.00,
                'sale_price' => 24.99,
                'external_url' => 'https://best.aliexpress.com/item/1005003322114.html',
                'image_url' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Pantalla IPS de 3.5 pulgadas, emulador multiconsola (PS1, GBA, NES, SNES) y salida TV HDMI.',
                'description' => 'Revive los clásicos de la infancia. Esta consola portátil incluye miles de títulos legendarios instalados, batería recargable de 3500 mAh y soporte para dos mandos externos.',
            ],
            [
                'external_id' => 'ali_007',
                'title' => 'Soporte Cargador Inalámbrico Magsafe 3 en 1 para iPhone, Watch y AirPods',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 12.90,
                'price' => 38.00,
                'sale_price' => 21.50,
                'external_url' => 'https://best.aliexpress.com/item/1005001122334.html',
                'image_url' => 'https://images.unsplash.com/photo-1586816879360-004f5b0c51e3?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Carga rápida magnética de 15W, luz LED nocturna táctil y diseño plegable de aluminio.',
                'description' => 'Simplifica tu mesa de noche o escritorio. Carga simultáneamente tu smartphone, reloj inteligente y audífonos sin enredos de cables y con máxima eficiencia térmica.',
            ],
            [
                'external_id' => 'ali_008',
                'title' => 'Teclado Mecánico Gamer RGB Transparente Hot-Swap 61 Teclas',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 22.00,
                'price' => 59.99,
                'sale_price' => 34.90,
                'external_url' => 'https://best.aliexpress.com/item/1005005544332.html',
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Carcasa acrílica transparente, iluminación RGB programable y switches intercambiables.',
                'description' => 'Destaca en tu setup gamer con este teclado compacto del 60%. Teclas translúcidas de policarbonato con software custom para modificar macros y patrones lumínicos.',
            ],
            [
                'external_id' => 'ali_009',
                'title' => 'Mouse Gamer Inalámbrico PAW3395 Ultra Ligero 49g 26000 DPI',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 19.80,
                'price' => 49.00,
                'sale_price' => 29.99,
                'external_url' => 'https://best.aliexpress.com/item/1005006677889.html',
                'image_url' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Sensor óptico de alta precisión PAW3395, 1000Hz de sondeo y batería de 70 horas.',
                'description' => 'Máxima ligereza sin perforaciones en la carcasa. Ofrece velocidad, precisión en juegos de disparos eSports y conectividad inalámbrica de 2.4GHz sin pérdidas de señal.',
            ],
            [
                'external_id' => 'ali_010',
                'title' => 'Micrófono de Condensador USB RGB para Streaming y Podcast',
                'category_slug' => 'audio-sonido-premium',
                'platform_name' => 'aliexpress',
                'supplier_price' => 14.00,
                'price' => 39.90,
                'sale_price' => 22.50,
                'external_url' => 'https://best.aliexpress.com/item/1005007788990.html',
                'image_url' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Botón Mute táctil, patrón cardioide de sonido y filtro antipop desmontable incluido.',
                'description' => 'Mejora la calidad de audio en tus llamadas de Discord, streams en Twitch o grabaciones de YouTube. Su patrón polar cardioide reduce ruidos de fondo no deseados.',
            ],
            [
                'external_id' => 'ali_011',
                'title' => 'Cámara de Acción 4K 60FPS Impermeable Pantalla Dual',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 31.00,
                'price' => 79.99,
                'sale_price' => 45.00,
                'external_url' => 'https://best.aliexpress.com/item/1005004455667.html',
                'image_url' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Estabilizador giroscópico EIS 6-Axis, lente gran angular 170° y carcasa para 30m bajo agua.',
                'description' => 'Graba tus deportes extremos, viajes y vlogueo con excelente calidad visual. La pantalla frontal táctil de 1.3" facilita el encuadre perfecto en selfies.',
            ],
            [
                'external_id' => 'ali_012',
                'title' => 'Lentes de Realidad Virtual VR 3D Ajustable para Smartphone',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 9.90,
                'price' => 26.00,
                'sale_price' => 14.99,
                'external_url' => 'https://best.aliexpress.com/item/1005001199887.html',
                'image_url' => 'https://images.unsplash.com/photo-1622979135225-d2ba269bc1bd?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Lentes ópticos HD con ajuste focal y pupilar, almohadilla transpirable y control Bluetooth.',
                'description' => 'Sumérgete en juegos e historias de 360 grados usando tu propio celular. Compatible con teléfonos de 4.7 a 6.7 pulgadas.',
            ],
            [
                'external_id' => 'ali_013',
                'title' => 'Hub USB-C 8 en 1 Aluminio con 4K HDMI, SD y Carga PD 100W',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 10.50,
                'price' => 29.99,
                'sale_price' => 17.80,
                'external_url' => 'https://best.aliexpress.com/item/1005008899001.html',
                'image_url' => 'https://images.unsplash.com/photo-1544652478-6653e09f18a2?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Multiplica los puertos de tu MacBook, laptop o iPad con acabado en aleación de aluminio.',
                'description' => 'Expande tu conectividad al instante: salida HDMI 4K a 60Hz, 3 puertos USB 3.0 de alta velocidad, lector de tarjetas SD/MicroSD y puerto de carga Power Delivery de 100W.',
            ],
            [
                'external_id' => 'ali_014',
                'title' => 'Altavoz Portátil Bluetooth Potente 40W Bass Boost IPX7',
                'category_slug' => 'audio-sonido-premium',
                'platform_name' => 'aliexpress',
                'supplier_price' => 25.00,
                'price' => 69.90,
                'sale_price' => 39.99,
                'external_url' => 'https://best.aliexpress.com/item/1005003344556.html',
                'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Radiadores pasivos duales para bajos profundos, 24h de reproducción y emparejamiento TWS.',
                'description' => 'Lleva la fiesta a donde quieras. Este altavoz todoterreno resiste lluvias e inmersiones breves mientras entrega graves impactantes que llenan cualquier habitación.',
            ],
            [
                'external_id' => 'ali_015',
                'title' => 'Auriculares Over-Ear ANC Hi-Res con Almohadillas Viscoelásticas',
                'category_slug' => 'audio-sonido-premium',
                'platform_name' => 'aliexpress',
                'supplier_price' => 28.50,
                'price' => 79.99,
                'sale_price' => 46.00,
                'external_url' => 'https://best.aliexpress.com/item/1005002233445.html',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Cancelación activa de ruido de 38dB, códec LDAC de alta resolución y 60h de batería.',
                'description' => 'Aíslate del ruido exterior en viajes o trabajo. Sonido enriquecido con drivers dinámicos de 40mm y llamadas nítidas gracias a sus 4 micrófonos con IA.',
            ],
            [
                'external_id' => 'ali_016',
                'title' => 'Mochila Inteligente Antirrobo con Puerto USB y Candado TSA',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'aliexpress',
                'supplier_price' => 17.20,
                'price' => 45.00,
                'sale_price' => 26.90,
                'external_url' => 'https://best.aliexpress.com/item/1005007711223.html',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Material de tela Oxford impermeable, compartimento acolchado para laptop 15.6" y tiras reflectantes.',
                'description' => 'Pensada para viajes urbanos y de negocios. Cremalleras ocultas antirrobo, candado numérico aprobado por TSA y puerto USB exterior para recargar tus dispositivos.',
            ],
            [
                'external_id' => 'ali_017',
                'title' => 'Compresor de Aire Portátil Digital para Neumáticos y Balones',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 16.50,
                'price' => 42.00,
                'sale_price' => 25.99,
                'external_url' => 'https://best.aliexpress.com/item/1005009900112.html',
                'image_url' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Inflado automático hasta 150 PSI, pantalla LCD digital y linterna LED de emergencia.',
                'description' => 'Nunca te quedes varado en la carretera. Infla neumáticos de auto, motocicleta, bicicleta y pelotas en pocos minutos con detección automática de presión.',
            ],
            [
                'external_id' => 'ali_018',
                'title' => 'Cepillo de Dientes Eléctrico Ultrasónico 5 Modos con 8 Cabezales',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 7.50,
                'price' => 24.99,
                'sale_price' => 12.90,
                'external_url' => 'https://best.aliexpress.com/item/1005004411223.html',
                'image_url' => 'https://images.unsplash.com/photo-1559671902-3b7547c6c7b2?auto=format&fit=crop&w=800&q=80',
                'short_description' => '42.000 vibraciones por minuto, temporizador inteligente de 2 min e impermeabilidad IPX7.',
                'description' => 'Limpieza dental profunda y blanqueamiento efectivo en casa. Batería de litio recargable mediante USB que dura hasta 90 días con una sola carga.',
            ],
            [
                'external_id' => 'ali_019',
                'title' => 'Masajeador Cervical y Espalda con Calor Infrarrojo 3D',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 15.00,
                'price' => 44.00,
                'sale_price' => 24.50,
                'external_url' => 'https://best.aliexpress.com/item/1005006611223.html',
                'image_url' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=800&q=80',
                'short_description' => '8 nodos de amasamiento Shiatsu, función de calentamiento suave y apagado automático.',
                'description' => 'Alivia la tensión muscular acumulada por el estrés diario o el trabajo de oficina. Diseño ergonómico adaptable a cuello, hombros, espalda y piernas.',
            ],
            [
                'external_id' => 'ali_020',
                'title' => 'Lámpara Ambientador Volcánico de Levitación Magnética',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 21.00,
                'price' => 58.00,
                'sale_price' => 33.90,
                'external_url' => 'https://best.aliexpress.com/item/1005008822334.html',
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Esfera flotante en el aire con rotación 360°, luces RGB ambientales y difusor aromático.',
                'description' => 'Decoración futurista fascinante para escritorios y veladores. Utiliza tecnología de levitación electromagnética para mantener una luna o volcán flotando suspendido.',
            ],
            [
                'external_id' => 'ali_021',
                'title' => 'Aspiradora de Mano Inalámbrica Potente 12000Pa para Auto y Hogar',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 13.80,
                'price' => 36.00,
                'sale_price' => 21.90,
                'external_url' => 'https://best.aliexpress.com/item/1005003311223.html',
                'image_url' => 'https://images.unsplash.com/photo-1558317374-067fb5f30001?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Filtro HEPA lavable, motor sin escobillas y boquillas intercambiables para rincones difíciles.',
                'description' => 'Limpia migas, polvo y pelos de mascotas rápidamente. Compacta, ligera y recargable por USB-C con autonomía de hasta 30 minutos continuos.',
            ],
            [
                'external_id' => 'ali_022',
                'title' => 'Dispensador de Agua Automático Inteligente para Mascotas',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'aliexpress',
                'supplier_price' => 11.50,
                'price' => 32.00,
                'sale_price' => 18.50,
                'external_url' => 'https://best.aliexpress.com/item/1005007744556.html',
                'image_url' => 'https://images.unsplash.com/photo-1548767797-d8c844163c4c?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Capacidad de 2.5 Litros, filtración múltiple de carbono activo y bomba ultra silenciosa.',
                'description' => 'Fomenta la hidratación continua de perros y gatos ofreciéndoles un flujo de agua fresca y circulante libre de impurezas y malos olores.',
            ],
            [
                'external_id' => 'ali_023',
                'title' => 'Localizador GPS Mini Rastreador en Tiempo Real con Imán Potente',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'aliexpress',
                'supplier_price' => 6.90,
                'price' => 22.00,
                'sale_price' => 11.80,
                'external_url' => 'https://best.aliexpress.com/item/1005001144556.html',
                'image_url' => 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Seguimiento por App gratuita, geocerca de seguridad y alerta de choque o movimiento.',
                'description' => 'Protege tus vehículos, maletas u objetos valiosos. Rastrea la ubicación exacta desde tu smartphone con historial de rutas y alerta sos instantánea.',
            ],
            [
                'external_id' => 'ali_024',
                'title' => 'Termo Inteligente de Acero Inoxidable con Pantalla LED',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'aliexpress',
                'supplier_price' => 5.80,
                'price' => 19.99,
                'sale_price' => 9.90,
                'external_url' => 'https://best.aliexpress.com/item/1005005511223.html',
                'image_url' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Capacidad 500ml, aislamiento al vacío de doble pared y sensor táctil de temperatura.',
                'description' => 'Mantiene tus bebidas frías o calientes hasta por 12 horas. Toca la tapa para ver la temperatura exacta del líquido en su pantalla táctil HD sin abrir la botella.',
            ],
            [
                'external_id' => 'ali_025',
                'title' => 'Anillo Inteligente Smart Ring Monitor de Sueño y Salud IP68',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'aliexpress',
                'supplier_price' => 24.00,
                'price' => 65.00,
                'sale_price' => 38.00,
                'external_url' => 'https://best.aliexpress.com/item/1005009988112.html',
                'image_url' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Construcción en cerámica de titanio, pulsómetros de precisión y 7 días de batería.',
                'description' => 'La alternativa discreta y cómoda al reloj inteligente. Monitorea tu ritmo cardíaco, pasos, calorías y fases de sueño profundo sin incomodar en tu muñeca.',
            ],

            // ==========================================
            // TEMU PRODUCTS (15 Items)
            // ==========================================
            [
                'external_id' => 'temu_001',
                'title' => 'Mini Impresora Térmica Portátil Bluetooth para Fotos y Stickers',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'temu',
                'supplier_price' => 9.80,
                'price' => 28.00,
                'sale_price' => 16.50,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109951234',
                'image_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Sin tinta (tecnología térmica), conexión inalámbrica desde tu smartphone e incluye 5 rollos de papel.',
                'description' => 'Imprime notas, listas de compras, stickers y fotos al instante desde tu teléfono mediante la aplicación gratuita. Tamaño de bolsillo ideal para estudiantes y creativos.',
            ],
            [
                'external_id' => 'temu_002',
                'title' => 'Altavoz Bluetooth Vintage Transparente con Luces de Neón RGB',
                'category_slug' => 'audio-sonido-premium',
                'platform_name' => 'temu',
                'supplier_price' => 14.50,
                'price' => 39.99,
                'sale_price' => 22.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109977889',
                'image_url' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Sonido surround 360°, batería recargable de larga duración y cuerpo acrílico transparente.',
                'description' => 'Un accesorio de audio único con estética cyberpunk futurista. Transmite un sonido potente y nítido mientras sus luces de neón parpadean al ritmo del bajo.',
            ],
            [
                'external_id' => 'temu_003',
                'title' => 'Gafas de Sol Estilo Retro Futurista con Filtro UV400',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'temu',
                'supplier_price' => 4.20,
                'price' => 19.00,
                'sale_price' => 9.99,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109933445',
                'image_url' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Protección 100% UV400, montura ligera de policarbonato y acabado espejado.',
                'description' => 'Diseño icónico de alta tendencia urbana. Protegen tus ojos contra los rayos dañinos mientras le dan un toque moderno y atrevido a tu estilo diario.',
            ],
            [
                'external_id' => 'temu_004',
                'title' => 'Humidificador Difusor de Aromas Efecto Llama de Fuego LED',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 12.00,
                'price' => 35.00,
                'sale_price' => 21.80,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109911223',
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Efecto de llama volcánica realista, funcionamiento ultrasónico silencioso y apagado automático.',
                'description' => 'Transforma el ambiente de tu dormitorio u oficina. Agrega tus aceites esenciales favoritos y disfruta de una niebla suave iluminada con un fascinante efecto de fuego cálido.',
            ],
            [
                'external_id' => 'temu_005',
                'title' => 'Organizador Modular de Cableado y Gestión Desk Setup',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'temu',
                'supplier_price' => 3.50,
                'price' => 14.00,
                'sale_price' => 7.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109922334',
                'image_url' => 'https://images.unsplash.com/photo-1586816879360-004f5b0c51e3?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Clips magnéticos adhesivos de silicona, ordenamiento rápido de cables USB y cargadores.',
                'description' => 'Mantén tu escritorio libre de marañas. Se adhiere firmemente a cualquier superficie de madera, vidrio o metal para fijar los cables al alcance de tu mano.',
            ],
            [
                'external_id' => 'temu_006',
                'title' => 'Cortador de Pelo y Barba Profesional Vintage T-Blade Recargable',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'temu',
                'supplier_price' => 7.80,
                'price' => 25.00,
                'sale_price' => 13.50,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109944556',
                'image_url' => 'https://images.unsplash.com/photo-1621607512214-68297480165e?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Cuchilla de titanio en T con corte cero, cuerpo metálico grabado y 4 peines guía.',
                'description' => 'Diseño retro de barbería tradicional. Ideal para perfilados de precisión en patillas, barba y diseños de cabello con motor potente de bajo nivel de ruido.',
            ],
            [
                'external_id' => 'temu_007',
                'title' => 'Mini Ventilador de Cuello Manos Libres Recargable 3 Velocidades',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 6.50,
                'price' => 22.00,
                'sale_price' => 11.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109966778',
                'image_url' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Diseño tipo auriculares sin aspas (seguro para el pelo), 360° de flujo de aire fresco y 4000mAh.',
                'description' => 'Mantén el frescor mientras caminas, viajas o haces ejercicio al aire libre. Sistema de turbina doble ultra silencioso que proporciona brisa constante en cuello y rostro.',
            ],
            [
                'external_id' => 'temu_008',
                'title' => 'Alfombrilla de Escritorio XXL Cuero Sintético Impermeable 90x40cm',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'temu',
                'supplier_price' => 5.20,
                'price' => 18.00,
                'sale_price' => 9.80,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109988990',
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Doble cara utilizable, superficie suave antideslizante y fácil limpieza contra derrames.',
                'description' => 'Protege la madera de tu mesa y dale un aspecto sofisticado a tu espacio de trabajo. Permite un deslizamiento fluido del mouse y espacio amplio para teclado y accesorios.',
            ],
            [
                'external_id' => 'temu_009',
                'title' => 'Proyector Astral Astronauta Luz Galaxia y Estrellas con Control',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 13.90,
                'price' => 38.00,
                'sale_price' => 22.00,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109911990',
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Cabeza magnética giratoria 360°, 8 efectos de nebulosa deslumbrantes y temporizador de apagado.',
                'description' => 'Crea una atmósfera mágica de universo estrellado en el techo de la habitación. Regalo ideal para niños y amantes de la astronomía.',
            ],
            [
                'external_id' => 'temu_010',
                'title' => 'Botella de Agua Motivacional 2 Litros con Marcador de Tiempo',
                'category_slug' => 'moda-accesorios',
                'platform_name' => 'temu',
                'supplier_price' => 3.90,
                'price' => 16.00,
                'sale_price' => 8.50,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109933887',
                'image_url' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Plástico Libre de BPA, sorbete de silicona de grado alimenticio y manija de transporte.',
                'description' => 'Asegúrate de cumplir tus metas diarias de hidratación en el gimnasio o la oficina. Cuenta con frases motivacionales graduadas por horas del día.',
            ],
            [
                'external_id' => 'temu_011',
                'title' => 'Mini Sellador Térmico de Bolsas Portátil 2 en 1 con Cortador',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 2.80,
                'price' => 12.00,
                'sale_price' => 5.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109944778',
                'image_url' => 'https://images.unsplash.com/photo-1558317374-067fb5f30001?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Calentamiento instantáneo, imán posterior para refrigerador y batería recargable USB.',
                'description' => 'Mantiene los snacks, papas fritas y alimentos frescos por más tiempo. Sella herméticamente cualquier bolsa plástica en segundos para evitar que se humedezcan.',
            ],
            [
                'external_id' => 'temu_012',
                'title' => 'Báscula Digital Inteligente Corporal con Bluetooth y App Móvil',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 8.90,
                'price' => 27.00,
                'sale_price' => 15.80,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109955112',
                'image_url' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=800&q=80',
                'short_description' => 'Medición de 13 métricas corporales (IMC, % grasa, masa muscular, agua) y vidrio templado.',
                'description' => 'Realiza un seguimiento riguroso de tus progresos fitness. Se sincroniza automáticamente con tu celular registrando gráficas de evolución física.',
            ],
            [
                'external_id' => 'temu_013',
                'title' => 'Limpiador Ultrasónico de Joyas, Gafas y Relojes Portátil',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 7.20,
                'price' => 23.00,
                'sale_price' => 12.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109966223',
                'image_url' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
                'short_description' => '45.000 Hz de ondas ultrasónicas de alta frecuencia, tanque de acero inoxidable de 350ml.',
                'description' => 'Elimina la suciedad incrustada en rincones inaccesibles solo usando agua de grifo. Devuelve el brillo a tus anillos, collares, gafas y alineadores dentales.',
            ],
            [
                'external_id' => 'temu_014',
                'title' => 'Soporte Plegable de Aluminio para Laptop y Tablet Regulable',
                'category_slug' => 'electronica-gadgets',
                'platform_name' => 'temu',
                'supplier_price' => 6.10,
                'price' => 20.00,
                'sale_price' => 10.90,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109977334',
                'image_url' => 'https://images.unsplash.com/photo-1544652478-6653e09f18a2?auto=format&fit=crop&w=800&q=80',
                'short_description' => '6 niveles de inclinación ergonómica, almohadillas antideslizantes de silicona e incluye funda.',
                'description' => 'Mejora tu postura al trabajar y evita el sobrecalentamiento de tu laptop elevando la base para una ventilación óptima de los componentes.',
            ],
            [
                'external_id' => 'temu_015',
                'title' => 'Foco LED Inteligente RGB WiFi Regulable E27 para Alexa y Google',
                'category_slug' => 'hogar-smart-living',
                'platform_name' => 'temu',
                'supplier_price' => 3.80,
                'price' => 15.00,
                'sale_price' => 7.50,
                'external_url' => 'https://www.temu.com/goods.html?goods_id=60109988445',
                'image_url' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80',
                'short_description' => '16 Millones de colores, temporizadores de encendido/apagado y 9W equivalentes a 80W.',
                'description' => 'Controla la iluminación de tu hogar desde cualquier parte con tu smartphone o mediante comandos de voz. Ajusta la intensidad, temperatura y escena cromática.',
            ],
        ];

        // Apply Platform Filter
        $platform = $request->get('platform', 'all');
        if ($platform !== 'all') {
            $externalCatalog = array_filter($externalCatalog, fn($item) => $item['platform_name'] === $platform);
        }

        // Apply Category Filter
        $categorySlug = $request->get('category', 'all');
        if ($categorySlug !== 'all') {
            $externalCatalog = array_filter($externalCatalog, fn($item) => $item['category_slug'] === $categorySlug);
        }

        // Apply Search Query
        $search = $request->get('search');
        if (!empty($search)) {
            $externalCatalog = array_filter($externalCatalog, function ($item) use ($search) {
                return Str::contains(mb_strtolower($item['title']), mb_strtolower($search)) ||
                       Str::contains(mb_strtolower($item['description']), mb_strtolower($search));
            });
        }

        // Fetch already imported external URLs to prevent duplicate import buttons
        $importedUrls = Product::pluck('external_url')->filter()->toArray();

        return view('importar.index', compact('externalCatalog', 'categories', 'importedUrls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'external_url' => 'required|string',
            'title' => 'nullable|string|max:255',
            'category_slug' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'platform_name' => 'nullable|string',
            'image_url' => 'nullable|url',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $url = $request->external_url;

        // Check if product with same external_url already exists
        if (Product::where('external_url', $url)->exists()) {
            return back()->with('error', 'Este producto ya ha sido importado previamente a tu catálogo.');
        }

        // Platform detection
        $platform = $request->platform_name;
        if (empty($platform)) {
            $platform = Str::contains(strtolower($url), 'temu') ? 'temu' : 'aliexpress';
        }

        // Category fallback
        $category = Category::where('slug', $request->category_slug)->first() ?? Category::first();

        // Title fallback
        $title = $request->title;
        if (empty($title)) {
            $pathParts = explode('/', parse_url($url, PHP_URL_PATH) ?? '');
            $lastPart = end($pathParts);
            $cleanName = Str::title(str_replace(['-', '_', '.html'], ' ', $lastPart));
            $title = (!empty($cleanName) && strlen($cleanName) > 4) ? $cleanName : 'Producto Novedad ' . ucfirst($platform);
        }

        // Prices fallback
        $price = $request->price ? (float)$request->price : 39.99;
        $salePrice = $request->sale_price ? (float)$request->sale_price : 24.99;

        // Image fallback
        $imageUrl = $request->image_url;
        if (empty($imageUrl)) {
            $imageUrl = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=800&q=80';
        }

        // Generate unique slug
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        // Create product
        $product = Product::create([
            'category_id' => $category->id,
            'title' => $title,
            'slug' => $slug,
            'short_description' => $request->short_description ?? 'Producto importado de la plataforma ' . ucfirst($platform) . '.',
            'description' => $request->description ?? 'Producto disponible mediante enlace de afiliado verificado en ' . ucfirst($platform) . '.',
            'price' => $price,
            'sale_price' => $salePrice,
            'type' => 'affiliate',
            'external_url' => $url,
            'platform_name' => $platform,
            'stock' => 0,
            'is_featured' => true,
            'is_active' => true,
        ]);

        // Add primary image
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imageUrl,
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        return back()->with('success', "¡Producto '{$product->title}' importado con éxito a tu catálogo público!");
    }
}

