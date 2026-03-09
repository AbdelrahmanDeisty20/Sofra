<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Street;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SofraDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $categoriesData = [
            ['name' => 'مشويات'],
            ['name' => 'بيتزا'],
            ['name' => 'برجر'],
            ['name' => 'شرقي'],
            ['name' => 'حلويات'],
            ['name' => 'مأكولات بحرية'],
            ['name' => 'إيطالي'],
            ['name' => 'صيني'],
        ];

        foreach ($categoriesData as $cat) {
            Category::firstOrCreate($cat);
        }

        $cats = Category::all();
        $regions = Street::all();

        if ($regions->isEmpty()) {
            return;
        }

        // 2. Restaurants (Using User model with type restaurant)
        $restaurantsData = [
            [
                'name' => 'قصر المشويات',
                'email' => 'grill@sofra.com',
                'phone' => '01011111111',
                'minimum_order' => 100,
                'delivery_fees' => 20,
                'whatsapp' => '01011111111',
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'نابولي بيتزا',
                'email' => 'napoli@sofra.com',
                'phone' => '01022222222',
                'minimum_order' => 150,
                'delivery_fees' => 15,
                'whatsapp' => '01022222222',
                'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'بافلو برجر',
                'email' => 'buffalo@sofra.com',
                'phone' => '01033333333',
                'minimum_order' => 80,
                'delivery_fees' => 25,
                'whatsapp' => '01033333333',
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'name' => 'البرنس',
                'email' => 'prince@sofra.com',
                'phone' => '01044444444',
                'minimum_order' => 200,
                'delivery_fees' => 30,
                'whatsapp' => '01044444444',
                'image' => 'https://images.unsplash.com/photo-1544148103-0773bf10dcae?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($restaurantsData as $data) {
            $restaurant = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('123456'),
                    'region_id' => $regions->random()->id,
                    'status' => 1,
                    'type' => UserType::RESTAURANT,
                    'pin_code' => rand(1000, 9999)
                ])
            );

            // Link categories to restaurant
            $restaurant->categories()->sync($cats->random(2)->pluck('id'));

            // Add products for each restaurant
            $productsData = [
                ['name' => 'وجبة عائلية', 'price' => 350, 'details' => 'كيلو مشكل مشويات مع أرز وسلطات'],
                ['name' => 'بيتزا رانش', 'price' => 120, 'details' => 'دجاج رانش مع صوص الجبنة المميز'],
                ['name' => 'بيف برجر دبل', 'price' => 95, 'details' => 'قطعتين لحم 200 جرام مع صوص الشيدر'],
                ['name' => 'طبق كوارع', 'price' => 180, 'details' => 'كوارع مطبوخة على الطريقة الشرقية'],
            ];

            foreach ($productsData as $pData) {
                Product::create(array_merge($pData, [
                    'restaurant_id' => $restaurant->id,
                    'image' => 'https://via.placeholder.com/300x200?text=FoodItem',
                    'ready' => '1',
                    'stock' => rand(10, 100),
                    'offer_price' => $pData['price'] * 0.9,
                ]));
            }

            // Add 1 offer for each restaurant
            Offer::create([
                'name' => 'خصم الافتتاح',
                'details' => 'استمتع بخصم 20% على جميع الوجبات لفترة محدودة',
                'image' => 'https://via.placeholder.com/600x400?text=Offer',
                'restaurant_id' => $restaurant->id,
                'start_time' => now(),
                'end_time' => now()->addDays(30),
            ]);
        }
    }
}
