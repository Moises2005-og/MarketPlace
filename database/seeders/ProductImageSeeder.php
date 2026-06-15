<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /** Imagens reais por categoria (Unsplash) — slugs iguais à base de dados */
    private array $imagesByCategory = [
        'eletronica' => [
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'moda' => [
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c790?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'casa-e-jardim' => [
            'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1556911220-bff31c812dba?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1595428774223-ef5262410882?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'desporto' => [
            'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1519861537500-bb29029d9eb4?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'livros' => [
            'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1512820790801-4159f46bb636?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1524995997942-38c46c213267?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1471107340923-a7e20e491c5b?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1516979187450-601bbb118919?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'beleza' => [
            'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1487412947727-353ce3adfa45?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1596755389378-c179d47f1bf7?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1631214524020-7b1475d7500d?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'brinquedos' => [
            'https://images.unsplash.com/photo-1558060370-d644479cb6f7?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1515488042361-ee00e8170fcd?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1530325552611-64f770329c39?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1558877385-1199deaed8d5?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1596464716127-f2a82984de8a?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=800&h=800&q=80',
        ],
        'automovel' => [
            'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1625047509248-ec889cbff17f?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?auto=format&fit=crop&w=800&h=800&q=80',
            'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?auto=format&fit=crop&w=800&h=800&q=80',
        ],
    ];

    private array $fallbackImages = [
        'https://images.unsplash.com/photo-1472851294607-062f824d29cc?auto=format&fit=crop&w=800&h=800&q=80',
        'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&h=800&q=80',
        'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=800&h=800&q=80',
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $products = Product::with('category')->get();
        $localCount = 0;
        $remoteCount = 0;

        foreach ($products as $index => $product) {
            $slug = $product->category?->slug ?? 'geral';
            $pool = $this->imagesByCategory[$slug] ?? $this->fallbackImages;

            $product->images()->delete();

            $mainUrl = $pool[$index % count($pool)];
            $mainResolved = $this->resolveImage($mainUrl, "products/{$product->id}-main.jpg");
            $this->deleteLocalIfReplaced($product->main_image, $mainResolved);
            $product->update(['main_image' => $mainResolved]);
            str_starts_with($mainResolved, 'http') ? $remoteCount++ : $localCount++;

            $galleryCount = $product->is_featured ? 3 : 2;

            for ($g = 1; $g <= $galleryCount; $g++) {
                $galleryUrl = $pool[($index + $g) % count($pool)];
                $galleryResolved = $this->resolveImage($galleryUrl, "products/{$product->id}-gallery-{$g}.jpg");

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryResolved,
                    'sort_order' => $g,
                ]);

                str_starts_with($galleryResolved, 'http') ? $remoteCount++ : $localCount++;
            }
        }

        $this->command?->info("Imagens aplicadas a {$products->count()} produtos ({$localCount} locais, {$remoteCount} remotas).");
    }

    private function resolveImage(string $url, string $localPath): string
    {
        $downloaded = $this->downloadImage($url, $localPath);

        return $downloaded ?? $url;
    }

    private function deleteLocalIfReplaced(?string $oldPath, string $newPath): void
    {
        if (! $oldPath || str_starts_with($oldPath, 'http')) {
            return;
        }

        if ($oldPath !== $newPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }

    private function downloadImage(string $url, string $path): ?string
    {
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['User-Agent' => 'Marketplace/1.0'])
                ->timeout(45)
                ->retry(3, 1000)
                ->get($url);

            if ($response->successful() && strlen($response->body()) > 1000) {
                Storage::disk('public')->put($path, $response->body());

                return $path;
            }
        } catch (\Throwable) {
            //
        }

        return null;
    }
}
