<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // //buat seeding secara manual
        User::create([
            'name' => 'Nur Aziilah',
            'username' => 'ilah',
            'email' => 'nuraziilahawg@gmail.com',
            'password' => bcrypt('password')
        ]);

        // User::create([
        //     'name' => 'Giselle Uchinaga',
        //     'email' => 'gisellegg@yahoo.com',
        //     'password' => bcrypt('54321')
        // ]);

        User::factory(3)->create();

        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);

        Category::create([
            'name' => 'Web Design',
            'slug' => 'web-design'
        ]);

        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        Post::factory(20)->create();

        // Post::create([
        //     'title' => 'Judul Pertama',
        //     'slug' => 'judul-pertama',
        //     'excerpt' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.',
        //     'body' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique id iste minus ipsa excepturi distinctio necessitatibus rerum temporibus doloremque enim accusamus at laborum est, provident exercitationem, repellat voluptates corporis voluptatem repudiandae laudantium quia consequuntur saepe! Laudantium voluptates vitae natus sed, eveniet provident nisi rem repudiandae maxime alias velit soluta repellendus! Ullam eligendi temporibus quisquam ipsa hic ad ea aliquid rem aliquam vel tenetur ratione praesentium magnam quo minus debitis doloribus maiores, aspernatur suscipit dolores explicabo repellendus blanditiis facilis. Atque provident ullam aperiam, culpa nulla ipsa necessitatibus dolor, animi, earum expedita voluptates quibusdam praesentium odit. Natus repudiandae ipsam aut. Totam, tempora.',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);

        // Post::create([
        //     'title' => 'Judul Kedua',
        //     'slug' => 'judul-ke-dua',
        //     'excerpt' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.',
        //     'body' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique id iste minus ipsa excepturi distinctio necessitatibus rerum temporibus doloremque enim accusamus at laborum est, provident exercitationem, repellat voluptates corporis voluptatem repudiandae laudantium quia consequuntur saepe! Laudantium voluptates vitae natus sed, eveniet provident nisi rem repudiandae maxime alias velit soluta repellendus! Ullam eligendi temporibus quisquam ipsa hic ad ea aliquid rem aliquam vel tenetur ratione praesentium magnam quo minus debitis doloribus maiores, aspernatur suscipit dolores explicabo repellendus blanditiis facilis. Atque provident ullam aperiam, culpa nulla ipsa necessitatibus dolor, animi, earum expedita voluptates quibusdam praesentium odit. Natus repudiandae ipsam aut. Totam, tempora.',
        //     'category_id' => 1,
        //     'user_id' => 1
        // ]);

        // Post::create([
        //     'title' => 'Judul Ketiga',
        //     'slug' => 'judul-ke-tiga',
        //     'excerpt' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.',
        //     'body' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique id iste minus ipsa excepturi distinctio necessitatibus rerum temporibus doloremque enim accusamus at laborum est, provident exercitationem, repellat voluptates corporis voluptatem repudiandae laudantium quia consequuntur saepe! Laudantium voluptates vitae natus sed, eveniet provident nisi rem repudiandae maxime alias velit soluta repellendus! Ullam eligendi temporibus quisquam ipsa hic ad ea aliquid rem aliquam vel tenetur ratione praesentium magnam quo minus debitis doloribus maiores, aspernatur suscipit dolores explicabo repellendus blanditiis facilis. Atque provident ullam aperiam, culpa nulla ipsa necessitatibus dolor, animi, earum expedita voluptates quibusdam praesentium odit. Natus repudiandae ipsam aut. Totam, tempora.',
        //     'category_id' => 2,
        //     'user_id' => 2
        // ]);

    }
}
