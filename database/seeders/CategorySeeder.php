<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Eletrónica' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&h=400&fit=crop',
            'Moda' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&h=400&fit=crop',
            'Casa e Jardim' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=400&fit=crop',
            'Desporto' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=600&h=400&fit=crop',
            'Livros' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=600&h=400&fit=crop',
            'Beleza' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=400&fit=crop',
            'Brinquedos' => 'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=600&h=400&fit=crop',
            'Automóvel' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&h=400&fit=crop',
        ];

        Storage::disk('public')->makeDirectory('categories');

        foreach ($categories as $name => $imageUrl) {
            $slug = Str::slug($name);
            $imagePath = null;

            try {
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders(['User-Agent' => 'Marketplace/1.0'])
                    ->timeout(45)
                    ->retry(3, 1000)
                    ->get($imageUrl.'&auto=format&q=80');

                if ($response->successful() && strlen($response->body()) > 1000) {
                    $imagePath = 'categories/'.$slug.'.jpg';
                    Storage::disk('public')->put($imagePath, $response->body());
                }
            } catch (\Throwable) {
                //
            }

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'description' => "Produtos na categoria {$name}",
                    'image' => $imagePath ?? $imageUrl,
                    'is_active' => true,
                ]
            );
        }
    }
}
