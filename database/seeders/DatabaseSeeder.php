<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Banner;
use App\Models\ProductVariant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@tokokue.com'],
            [
                'name' => 'Admin Toko Kue',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@tokokue.com'],
            [
                'name' => 'Budi Pelanggan',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '089876543210',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 3. Kategori Menu & Kue
        $categories = [
            [
                'name' => 'Donat Spesial',
                'slug' => 'donat',
                'icon' => 'circle-dot',
                'description' => 'Aneka donat kentang lembut dengan beragam pilihan glaze lumer dan topping melimpah.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pizza & Savory',
                'slug' => 'pizza',
                'icon' => 'pizza-slice',
                'description' => 'Pizza panggang hangat berlimpah keju mozarella mulur dan aneka topping daging gurih.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Kue Ulang Tahun',
                'slug' => 'kue-ulang-tahun',
                'icon' => 'cake',
                'description' => 'Berbagai kue ulang tahun tart cantik dan lezat untuk momen spesial.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Pastry & Croissant',
                'slug' => 'pastry-croissant',
                'icon' => 'croissant',
                'description' => 'Aneka pastry renyah dan croissant buttery yang dipanggang fresh setiap pagi.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Kue Kering & Cookies',
                'slug' => 'kue-kering-cookies',
                'icon' => 'cookie',
                'description' => 'Cookies lezat dan kue kering toples istimewa untuk hari raya atau cemilan santai.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Kue Tradisional',
                'slug' => 'kue-tradisional',
                'icon' => 'sparkles',
                'description' => 'Kue basah tradisional Indonesia dengan cita rasa autentik dan bahan alami.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Dessert Box & Cupcake',
                'slug' => 'dessert-box-cupcake',
                'icon' => 'box',
                'description' => 'Dessert box lembut lumer dan cupcake imut favorit semua usia.',
                'sort_order' => 7,
            ],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Sample Produk Kue
        $products = [
            [
                'category_id' => $catModels['kue-ulang-tahun']->id,
                'name' => 'Belgian Double Chocolate Tart',
                'slug' => 'belgian-double-chocolate-tart',
                'description' => 'Kue tart cokelat premium dengan lapisan ganache cokelat Belgia murni 70%, sponge cake super lembut, dan hiasan gold leaf elegan.',
                'ingredients' => 'Tepung terigu pro rendah, telur ayam omega, butter New Zealand, Belgian dark chocolate 70%, whipped cream, gula aren organik.',
                'allergens' => 'Mengandung susu, telur, gluten.',
                'price' => 320000,
                'discount_price' => 285000,
                'main_image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&auto=format&fit=crop&q=80',
                'stock' => 15,
                'min_order_days' => 1,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 124,
                'rating_avg' => 4.9,
                'rating_count' => 48,
            ],
            [
                'category_id' => $catModels['kue-ulang-tahun']->id,
                'name' => 'Fresh Strawberry Shortcake',
                'slug' => 'fresh-strawberry-shortcake',
                'description' => 'Sponge cake vanilla gaya Jepang yang ringan berpadu dengan fresh chantilly cream manis lembut dan potongan buah stroberi segar pilihan.',
                'ingredients' => 'Sponge cake vanilla, fresh strawberry Ciwidey, Japanese chantilly cream, simple syrup.',
                'allergens' => 'Mengandung susu, telur, gluten.',
                'price' => 280000,
                'discount_price' => null,
                'main_image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800&auto=format&fit=crop&q=80',
                'stock' => 10,
                'min_order_days' => 1,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 89,
                'rating_avg' => 4.8,
                'rating_count' => 32,
            ],
            [
                'category_id' => $catModels['pastry-croissant']->id,
                'name' => 'French Butter Croissant',
                'slug' => 'french-butter-croissant',
                'description' => 'Croissant klasik Prancis dengan tekstur luar renyah berlapis-lapis dan bagian dalam yang empuk lembut dengan aroma mentega Perancis menggoda.',
                'ingredients' => 'Tepung T45 Prancis, Elle & Vire butter 84%, ragi segar, susu UHT, madu murni.',
                'allergens' => 'Mengandung susu, gluten.',
                'price' => 26000,
                'discount_price' => null,
                'main_image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&auto=format&fit=crop&q=80',
                'stock' => 40,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 310,
                'rating_avg' => 5.0,
                'rating_count' => 95,
            ],
            [
                'category_id' => $catModels['pastry-croissant']->id,
                'name' => 'Pain au Chocolat',
                'slug' => 'pain-au-chocolat',
                'description' => 'Pastry puff klasik dengan dua batang dark chocolate batons premium di dalamnya. Sangat nikmat dinikmati bersama kopi atau teh hangat.',
                'ingredients' => 'Puff pastry dough, French butter, chocolate batons Valrhona.',
                'allergens' => 'Mengandung susu, gluten, kedelai.',
                'price' => 30000,
                'discount_price' => null,
                'main_image' => 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?w=800&auto=format&fit=crop&q=80',
                'stock' => 30,
                'min_order_days' => 0,
                'is_featured' => false,
                'is_best_seller' => false,
                'sold_count' => 180,
                'rating_avg' => 4.7,
                'rating_count' => 40,
            ],
            [
                'category_id' => $catModels['kue-kering-cookies']->id,
                'name' => 'Nastar Keju Wisman Spesial',
                'slug' => 'nastar-keju-wisman-spesial',
                'description' => 'Kue nastar lumer di mulut dibuat dengan 100% Wijsman butter dan selai nanas madu homemade tanpa bahan pengawet.',
                'ingredients' => 'Wijsman butter, kuning telur, keju edam tua, selai nanas madu alami, cengkeh.',
                'allergens' => 'Mengandung susu, telur, gluten.',
                'price' => 135000,
                'discount_price' => 120000,
                'main_image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=800&auto=format&fit=crop&q=80',
                'stock' => 25,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 250,
                'rating_avg' => 4.9,
                'rating_count' => 88,
            ],
            [
                'category_id' => $catModels['dessert-box-cupcake']->id,
                'name' => 'Tiramisu Crepe Dessert Box',
                'slug' => 'tiramisu-crepe-dessert-box',
                'description' => 'Perpaduan ladyfinger lembut dicelup espresso arabica, cream mascarpone Italia yang creamy, dan taburan cocoa powder murni.',
                'ingredients' => 'Ladyfinger biscuits, espresso arabica, mascarpone cheese, fresh cream, cocoa powder.',
                'allergens' => 'Mengandung susu, telur, kafein.',
                'price' => 65000,
                'discount_price' => null,
                'main_image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=800&auto=format&fit=crop&q=80',
                'stock' => 20,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => false,
                'sold_count' => 75,
                'rating_avg' => 4.8,
                'rating_count' => 22,
            ],
            // Menu Donat Spesial
            [
                'category_id' => $catModels['donat']->id,
                'name' => 'Donat Kentang Klasik',
                'slug' => 'donat-kentang-klasik',
                'description' => 'Donat kentang legendaris khas Khadijah yang dibuat dari olahan kentang asli pilihan. Menghasilkan tekstur adonan yang super lembut, empuk tahan lama, dan wangi mentega dengan taburan gula halus salju premium.',
                'ingredients' => 'Kentang kuning pilihan, tepung terigu protein tinggi, New Zealand butter, kuning telur segar, ragi alami, susu murni, gula halus salju.',
                'allergens' => 'Mengandung gluten, telur, susu.',
                'price' => 10000,
                'discount_price' => null,
                'main_image' => '/images/products/donat-kentang.png',
                'stock' => 50,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 320,
                'rating_avg' => 4.9,
                'rating_count' => 86,
            ],
            [
                'category_id' => $catModels['donat']->id,
                'name' => 'Donat Cokelat Meises',
                'slug' => 'donat-cokelat-meises',
                'description' => 'Donat kentang empuk yang dibalut lelehan dark chocolate ganache kental yang legit, lalu ditaburi limpahan meises cokelat renyah berkualitas di seluruh permukaannya.',
                'ingredients' => 'Kentang asli, tepung terigu, mentega, telur ayam, dark chocolate glaze, premium chocolate meises, susu UHT.',
                'allergens' => 'Mengandung gluten, telur, susu, kedelai.',
                'price' => 10000,
                'discount_price' => 9000,
                'main_image' => '/images/products/donat-cokelat.jpg',
                'stock' => 45,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 275,
                'rating_avg' => 4.9,
                'rating_count' => 70,
            ],
            [
                'category_id' => $catModels['donat']->id,
                'name' => 'Donat Cappuccino',
                'slug' => 'donat-cappuccino',
                'description' => 'Perpaduan sempurna tekstur donat kentang lembut dengan lumuran glaze cappuccino wangi khas kopi Italia dan sentuhan krim manis gurih yang seimbang.',
                'ingredients' => 'Kentang pilihan, tepung terigu, butter, ekstrak espresso arabica, cappuccino cream glaze, susu kental manis, choco crumble.',
                'allergens' => 'Mengandung gluten, telur, susu, kafein.',
                'price' => 10000,
                'discount_price' => null,
                'main_image' => '/images/products/donat-cappucino.jpg',
                'stock' => 35,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => false,
                'sold_count' => 140,
                'rating_avg' => 4.8,
                'rating_count' => 42,
            ],
            [
                'category_id' => $catModels['donat']->id,
                'name' => 'Donat Tiramisu Glaze',
                'slug' => 'donat-tiramisu-glaze',
                'description' => 'Sensasi dessert Italia dalam gigitan donat empuk! Dilapisi glaze tiramisu creamy mascarpone yang lumer di mulut dengan drizzle sirup moka dan taburan bubuk kakao murni.',
                'ingredients' => 'Kentang pilihan, tepung terigu, butter, mascarpone cream glaze, bubuk kakao murni, sirup moka, telur.',
                'allergens' => 'Mengandung gluten, telur, susu, kafein.',
                'price' => 11000,
                'discount_price' => 10000,
                'main_image' => '/images/products/donat-tiramisu.jpg',
                'stock' => 40,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 198,
                'rating_avg' => 4.9,
                'rating_count' => 56,
            ],
            // Menu Pizza & Savory
            [
                'category_id' => $catModels['pizza']->id,
                'name' => 'Pizza Ayam Cincang Mozarella',
                'slug' => 'pizza-ayam-cincang-mozarella',
                'description' => 'Pizza hangat dengan crust renyah empuk, saus bolognese tomat homemade, tumisan daging ayam cincang bumbu rempah gurih, dan lelehan keju mozarella mulur berlimpah.',
                'ingredients' => 'Pizza dough gandum artisan, daging ayam cincang segar, saus bolognese, keju mozarella murni, paprika hijau, oregano, extra virgin olive oil.',
                'allergens' => 'Mengandung gluten, susu.',
                'price' => 25000,
                'discount_price' => null,
                'main_image' => '/images/products/pizza-ayam-cincang-mozarella.png',
                'stock' => 50,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 185,
                'rating_avg' => 4.9,
                'rating_count' => 53,
            ],
            [
                'category_id' => $catModels['pizza']->id,
                'name' => 'Pizza Beef Patties Supreme',
                'slug' => 'pizza-beef-patties-supreme',
                'description' => 'Pizza spesial dengan topping potongan daging burger beef patties juicy 100% daging sapi, saus BBQ asap gurih manis, bawang bombay tumis manis, dan double melted mozarella.',
                'ingredients' => 'Pizza dough gandum, 100% beef patties juicy, saus BBQ smoky, bawang bombay merah, keju mozarella, keju cheddar parut, daun basil kering.',
                'allergens' => 'Mengandung gluten, susu, kedelai.',
                'price' => 22000,
                'discount_price' => null,
                'main_image' => '/images/products/pizza-beef-patties.png',
                'stock' => 50,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 210,
                'rating_avg' => 4.9,
                'rating_count' => 67,
            ],
            [
                'category_id' => $catModels['pizza']->id,
                'name' => 'Pizza Smoked Beef Mozarella',
                'slug' => 'pizza-smoked-beef-mozarella',
                'description' => 'Kombinasi klasik favorit pencinta pizza! Lembaran smoked beef pilihan yang smokey harum berpadu serasi dengan saus marinara segar dan lelehan keju mozarella meleleh mulur.',
                'ingredients' => 'Pizza dough empuk renyah, smoked beef sapi premium, saus marinara tomat Italia, keju mozarella, oregano kering, herba rosemary.',
                'allergens' => 'Mengandung gluten, susu.',
                'price' => 22000,
                'discount_price' => null,
                'main_image' => '/images/products/pizza-smoke-beef-mozarella.png',
                'stock' => 50,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => true,
                'sold_count' => 230,
                'rating_avg' => 4.9,
                'rating_count' => 72,
            ],
            [
                'category_id' => $catModels['pizza']->id,
                'name' => 'Pizza Sosis Jagung Keju',
                'slug' => 'pizza-sosis-jagung-keju',
                'description' => 'Pizza favorit keluarga dan anak-anak! Perpaduan irisan sosis sapi gurih, manis renyahnya jagung pipil manis segar, diselimuti saus keju creamy dan taburan keju mozarella.',
                'ingredients' => 'Pizza dough gandum, sosis sapi pilihan, jagung manis pipil segar, saus keju creamy, keju mozarella, taburan parsley cincang.',
                'allergens' => 'Mengandung gluten, susu, kedelai.',
                'price' => 15000,
                'discount_price' => null,
                'main_image' => '/images/products/pizza-sosis-jagung-keju.png',
                'stock' => 50,
                'min_order_days' => 0,
                'is_featured' => true,
                'is_best_seller' => false,
                'sold_count' => 145,
                'rating_avg' => 4.8,
                'rating_count' => 48,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }

        // 5. Varian Ukuran & Porsi Pemesanan (Sesuai Menu Happizza & Toko)
        $variants = [
            // 1. Pizza Sosis + Jagung + Keju (Ukuran 18: 15.000, Ukuran 22: 22.000)
            [
                'product_slug' => 'pizza-sosis-jagung-keju',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 18 (Diameter 18 cm)',
                'price_addition' => 0,
                'stock' => 50,
            ],
            [
                'product_slug' => 'pizza-sosis-jagung-keju',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 22 (Diameter 22 cm)',
                'price_addition' => 7000,
                'stock' => 50,
            ],
            // 2. Pizza Beef Patties + Mozzarella (Ukuran 18: 22.000, Ukuran 22: 35.000)
            [
                'product_slug' => 'pizza-beef-patties-supreme',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 18 (Diameter 18 cm)',
                'price_addition' => 0,
                'stock' => 50,
            ],
            [
                'product_slug' => 'pizza-beef-patties-supreme',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 22 (Diameter 22 cm)',
                'price_addition' => 13000,
                'stock' => 50,
            ],
            // 3. Pizza Smoked Beef + Mozzarella (Ukuran 18: 22.000, Ukuran 22: 35.000)
            [
                'product_slug' => 'pizza-smoked-beef-mozarella',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 18 (Diameter 18 cm)',
                'price_addition' => 0,
                'stock' => 50,
            ],
            [
                'product_slug' => 'pizza-smoked-beef-mozarella',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 22 (Diameter 22 cm)',
                'price_addition' => 13000,
                'stock' => 50,
            ],
            // 4. Pizza Ayam Cincang + Mozzarella (Ukuran 18: 25.000, Ukuran 22: 38.000)
            [
                'product_slug' => 'pizza-ayam-cincang-mozarella',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 18 (Diameter 18 cm)',
                'price_addition' => 0,
                'stock' => 50,
            ],
            [
                'product_slug' => 'pizza-ayam-cincang-mozarella',
                'type' => 'Ukuran Pizza',
                'value' => 'Ukuran 22 (Diameter 22 cm)',
                'price_addition' => 13000,
                'stock' => 50,
            ],
            // 5. Spesial Donat Kentang (3 Pcs: 10.000, 6 Pcs: 20.000)
            [
                'product_slug' => 'donat-kentang-klasik',
                'type' => 'Pilihan Porsi',
                'value' => 'Paket 3 Pcs Donat Kentang',
                'price_addition' => 0,
                'stock' => 100,
            ],
            [
                'product_slug' => 'donat-kentang-klasik',
                'type' => 'Pilihan Porsi',
                'value' => 'Paket 6 Pcs Donat Kentang',
                'price_addition' => 10000,
                'stock' => 100,
            ],
        ];

        foreach ($variants as $v) {
            $prod = Product::where('slug', $v['product_slug'])->first();
            if ($prod) {
                ProductVariant::updateOrCreate(
                    [
                        'product_id' => $prod->id,
                        'type' => $v['type'],
                        'value' => $v['value'],
                    ],
                    [
                        'price_addition' => $v['price_addition'],
                        'stock' => $v['stock'],
                        'is_active' => true,
                    ]
                );
            }
        }

        // 6. Setting default toko
        $settings = [
            'store_name' => 'Khadijah Donat & Cake',
            'store_phone' => '085360233531',
            'store_email' => 'halo@khadijahcake.com',
            'store_address' => 'Lr. SD (Jl. Paya Bili) No. 02, Panggoi, Kec. Muara Dua, Kota Lhokseumawe, Aceh',
            'store_instagram' => '@khadijahdonatcake',
            'store_tiktok' => '@khadijah.donat.n.c',
            'shipping_flat_cost' => '15000',
            'free_shipping_min' => '200000',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val, 'group' => 'general']);
        }
    }
}

