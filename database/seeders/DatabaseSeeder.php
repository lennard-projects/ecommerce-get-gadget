<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShoppingSession;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'address' => 'Liliw, Laguna',
            'contact' =>  '123123',
            'role' => 'admin',
            'password' => Hash::make('123123')
        ]);

        User::factory()->create([
            'name' => 'Front User',
            'email' => 'user@example.com',
            'address' => 'Liliw, Laguna',
            'contact' =>  '123123',
            'password' => Hash::make('123456')
        ]);


        User::factory(33)->create();
        // User::factory(10)->create([
        //     'name' => fake()->name(),
        //     'email' => fake()->unique()->safeEmail(),
        //     'address' => 'asd',
        //     'contact' => '123123',
        //     'password' => '123123'
        // ]);

        Product::factory(30)->create();

        // ShoppingSession::factory()->create();

        // CartItem::factory()->create([
        //     'shopping_session_id' => 1,
        //     'product_id' => 1,
        //     'quantity' => 5
        // ]);

        // CartItem::factory()->create([
        //     'shopping_session_id' => 1,
        //     'product_id' => 3,
        //     'quantity' => 3
        // ]);

        // Payment::factory(10)->create();

        // Order::factory(10)->create();

        // OrderItems::factory(10)->create();
    }
}
