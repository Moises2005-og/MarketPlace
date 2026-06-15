<?php

namespace App\Support;

class ProductImageCatalog
{
    /** URLs Unsplash por categoria — fallback quando não há imagem local */
    public static function urlForCategory(?string $slug, int $productId): string
    {
        $pools = [
            'eletronica' => [
                'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&h=800&q=80',
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&h=800&q=80',
                'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?auto=format&fit=crop&w=800&h=800&q=80',
            ],
            'moda' => [
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c790?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=600&h=600&fit=crop',
            ],
            'casa-e-jardim' => [
                'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=600&h=600&fit=crop',
            ],
            'desporto' => [
                'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=600&h=600&fit=crop',
            ],
            'livros' => [
                'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=600&h=600&fit=crop',
            ],
            'beleza' => [
                'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&h=600&fit=crop',
            ],
            'brinquedos' => [
                'https://images.unsplash.com/photo-1558060370-d644479cb6f7?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1515488042361-ee00e8170fcd?w=600&h=600&fit=crop',
            ],
            'automovel' => [
                'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&h=600&fit=crop',
                'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&h=600&fit=crop',
            ],
        ];

        $pool = $pools[$slug ?? ''] ?? [
            'https://images.unsplash.com/photo-1472851294607-062f824d29cc?w=600&h=600&fit=crop',
        ];

        return $pool[$productId % count($pool)];
    }
}
