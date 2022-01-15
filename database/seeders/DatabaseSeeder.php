<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Admin;
use App\Models\Service;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>'Fixar',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin')
        ]);
        
        $user = User::create([
            'name'=>'Alex',
            'username'=>'alex',
            'email'=>'alex@alex.com',
            'number'=>1111,
            'type'=>'Provider',
            'password'=>bcrypt('alex')
        ]);
        Service::create([
            'name'=>'Gardener',
            'slug'=>'gardener',
        ]);
        Service::create([
            'name'=>'Plumber',
            'slug'=>'plumber',
        ]);
        Service::create([
            'name'=>'Electrician',
            'slug'=>'electrician',
        ]);

        // User::create([
        //     'name'=>'Brad',
        //     'username'=>'brad',
        //     'email'=>'brad@brad.com',
        //     'number'=>2222,
        //     'type'=>'Customer',
        //     'password'=>bcrypt('brad')
        // ]);

    }
}
