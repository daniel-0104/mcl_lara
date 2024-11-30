<?php

namespace Database\Seeders;

use App\Models\info;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admindaniel@gmail.com',
            'password' => Hash::make('admin03@daniel'),
            'role' => 'admin',
            'project_permission' => 'mcl'
        ]);

        // Create a Developer account
        User::create([
            'name' => 'Developer',
            'email' => 'webdaniel03@gmail.com',
            'password' => Hash::make('daniel@0104.'),
            'role' => 'developer',
            'project_permission' => 'mcl'
        ]);


        info::create([
            'home_letter'=>'We’re a web development team that builds high-performance eCommerce websites designed for both desktop and mobile. With a focus on user-friendly design and business goals, we deliver websites that make a difference for both users and businesses.',
            'service_letter' => 'Let’s build something great together! Our team builds solutions that support business goals and improve user experiences.',
            'service_price' => '20000',
            'about_letter' => 'Our focus is on simple, elegant web designs that support client goals effortlessly, blending advanced tech with custom styling.',
            'contact_letter' => 'Contact us with your project ideas! From small startups to large corporations, our team is ready to deliver the web design or development expertise you need with a friendly and responsive approach.',
            'contact_phone' => '09980730638',
            'contact_email' => 'example@gmail.com',
            'logo_image' => 'admin/image/default.jpg'
        ]);
    }
}
