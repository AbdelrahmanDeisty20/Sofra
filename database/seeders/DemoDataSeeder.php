<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Street;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $regions = Street::all();
        if ($regions->isEmpty())
            return;

        // 1. Create Clients
        $clientsData = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@client.com', 'phone' => '01222222222'],
            ['name' => 'سارة علي', 'email' => 'sara@client.com', 'phone' => '01233333333'],
            ['name' => 'محمود حسن', 'email' => 'mahmoud@client.com', 'phone' => '01244444444'],
            ['name' => 'ليلى إبراهيم', 'email' => 'laila@client.com', 'phone' => '01255555555'],
        ];

        foreach ($clientsData as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => Hash::make('123456'),
                    'region_id' => $regions->random()->id,
                    'status' => 1,
                    'type' => UserType::CLIENT,
                    'pin_code' => rand(1000, 9999)
                ])
            );
        }

        $clients = User::where('type', UserType::CLIENT)->get();
        $restaurants = User::where('type', UserType::RESTAURANT)->get();

        if ($clients->isEmpty() || $restaurants->isEmpty())
            return;

        // 2. Create Orders
        $states = ['pending', 'accepted', 'rejected', 'delivered', 'declined'];

        foreach ($clients as $client) {
            foreach ($restaurants->random(2) as $restaurant) {
                $products = $restaurant->products()->limit(2)->get();
                if ($products->isEmpty())
                    continue;

                $order = Order::create([
                    'state' => $states[array_rand($states)],
                    'client_id' => $client->id,
                    'restaurant_id' => $restaurant->id,
                    'delivery_charge' => $restaurant->delivery_fees ?? 20,
                    'commission' => 10,
                    'address' => 'شارع الجلاء، عمارة 5',
                    'payment_method' => rand(0, 1) ? 'cash' : 'visa',
                    'note' => 'يرجى عدم التأخر',
                    'total_price' => 0,  // Will update via pivot
                ]);

                $total = 0;
                foreach ($products as $product) {
                    $qty = rand(1, 3);
                    $price = $product->offer_price ?? $product->price;
                    $order->products()->attach($product->id, [
                        'quantity' => $qty,
                        'price' => $price,
                        'note' => 'بدون شطة'
                    ]);
                    $total += ($price * $qty);
                }

                $order->update(['total_price' => $total + $order->delivery_charge]);

                // 3. Create Comments/Reviews
                Comment::create([
                    'comment' => 'تجربة ممتازة جداً والأكل سخن',
                    'rate' => rand(3, 5),
                    'client_id' => $client->id,
                    'restaurant_id' => $restaurant->id,
                ]);
            }
        }

        // 4. Create Settings
        Setting::firstOrCreate(['email' => 'support@sofra.com'], [
            'facebook_link' => 'https://facebook.com/sofra',
            'whatsapp' => '01011111111',
            'instagram_link' => 'https://instagram.com/sofra',
            'twitter_link' => 'https://twitter.com/sofra',
            'youtube_link' => 'https://youtube.com/sofra',
            'email' => 'support@sofra.com',
            'banks' => 'البنك الأهلي المصري: 1234567890',
            'commission_details' => 'عمولة البرنامج 10% على كل طلب ناجح',
        ]);

        // 5. Create Contacts
        Contact::create([
            'full_name' => 'كريم محمود',
            'email' => 'karim@test.com',
            'phone' => '01000000000',
            'subject' => 'استفسار عن اشتراك',
            'content' => 'كيف يمكنني إضافة مطعمي للمنصة؟',
            'type' => 'complaint',
        ]);
    }
}
