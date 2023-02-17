<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use App\Models\User;
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
        User::factory()->create([
            'name' => "Marco Castillo",
            'email' => "marco.castillo@emergys.com"
        ]);

        User::factory(99)
            ->sequence(fn($sequence) => ['name' => 'Person ' . $sequence->index + 2])
            ->create();

        foreach (range(1, 20) as $user_id) {
            // Create post
            $post = Post::factory()->create(['user_id' => $user_id]);

            // Adding images
            PostImage::create([
                "post_id" => $post->id,
                "url" => "post_images/image_post_test_1.jpg"
            ]);
            PostImage::create([
                "post_id" => $post->id,
                "url" => "post_images/image_post_test_2.jpg"
            ]);
            PostImage::create([
                "post_id" => $post->id,
                "url" => "post_images/image_post_test_3.jpeg"
            ]);
            foreach (range(1, 20) as $user_id2) {
                User::find($user_id)->follows()->attach(User::find($user_id2));
            }

            // Create comment
            PostComment::create([
                "user_id" => $user_id + 1,
                "post_id" => $post->id,
                "text" => "Este es un comentario creado por del DatabaseSeeder"
            ]);
        }

        // Post::factory(40)->create();
    }
}