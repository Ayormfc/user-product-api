<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
       
        User::factory(5)->create()->each(function ($user) {
            $user->products()->saveMany(
                Product::factory(3)->make()
            );
        });
    }
}