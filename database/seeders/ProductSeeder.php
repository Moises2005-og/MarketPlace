<?php

namespace Database\Seeders;

use App\Enums\ApprovalStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = User::whereHas('role', fn ($q) => $q->where('slug', 'seller'))->get();
        $categories = Category::all()->keyBy('slug');

        if ($sellers->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $catalog = $this->catalog();

        Product::query()->forceDelete();

        foreach ($catalog as $categorySlug => $products) {
            $category = $categories->get($categorySlug);
            if (! $category) {
                continue;
            }

            foreach ($products as $item) {
                Product::create([
                    'user_id' => $sellers->random()->id,
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'sku' => $item['sku'],
                    'is_active' => true,
                    'is_featured' => $item['featured'] ?? false,
                    'approval_status' => ApprovalStatus::Approved,
                    'view_count' => rand(50, 2500),
                ]);
            }
        }

        $this->command?->info('Criados '.Product::count().' produtos com nomes reais e preços em Kwanzas.');
    }

    private function catalog(): array
    {
        return [
            'eletronica' => [
                ['name' => 'Samsung Galaxy A54 5G 128GB', 'sku' => 'SAM-A54-128', 'price' => 285000, 'stock' => 24, 'featured' => true, 'description' => 'Smartphone Samsung Galaxy A54 5G com ecrã Super AMOLED de 6.4", câmara tripla de 50MP e bateria de 5000mAh. Ideal para o dia a dia.'],
                ['name' => 'iPhone 13 128GB', 'sku' => 'APL-IP13-128', 'price' => 520000, 'stock' => 12, 'featured' => true, 'description' => 'Apple iPhone 13 com chip A15 Bionic, ecrã OLED de 6.1" e sistema de câmaras avançado. Produto original com garantia.'],
                ['name' => 'Lenovo IdeaPad 3 15" AMD Ryzen 5', 'sku' => 'LEN-IP3-R5', 'price' => 395000, 'stock' => 8, 'description' => 'Portátil Lenovo IdeaPad 3 com processador AMD Ryzen 5, 8GB RAM e SSD 512GB. Perfeito para trabalho e estudos.'],
                ['name' => 'Sony WH-1000XM5 Auriculares', 'sku' => 'SNY-XM5-BK', 'price' => 178000, 'stock' => 18, 'featured' => true, 'description' => 'Auriculares sem fios Sony com cancelamento de ruído líder de mercado, 30h de autonomia e som Hi-Res.'],
                ['name' => 'Xiaomi Redmi Note 13 Pro', 'sku' => 'XIA-RN13P', 'price' => 198000, 'stock' => 30, 'description' => 'Xiaomi Redmi Note 13 Pro com câmara de 200MP, carregamento rápido de 67W e ecrã AMOLED 120Hz.'],
                ['name' => 'JBL Flip 6 Coluna Bluetooth', 'sku' => 'JBL-FLIP6', 'price' => 65000, 'stock' => 45, 'description' => 'Coluna portátil JBL Flip 6 à prova de água IP67, som potente e 12 horas de reprodução.'],
                ['name' => 'Samsung Smart TV 55" Crystal UHD', 'sku' => 'SAM-TV55-4K', 'price' => 420000, 'stock' => 6, 'description' => 'Televisão Samsung 55 polegadas 4K UHD com Tizen OS, HDR e design sem margens.'],
                ['name' => 'Canon EOS R50 Kit 18-45mm', 'sku' => 'CAN-R50-KIT', 'price' => 465000, 'stock' => 4, 'description' => 'Câmara mirrorless Canon EOS R50 com objetiva 18-45mm, ideal para fotografia e vídeo 4K.'],
            ],
            'moda' => [
                ['name' => 'Nike Air Max 90 Masculino', 'sku' => 'NIK-AM90-M', 'price' => 89000, 'stock' => 35, 'featured' => true, 'description' => 'Ténis Nike Air Max 90 clássicos, conforto Air cushioning e design icónico. Disponível em vários tamanhos.'],
                ['name' => 'Adidas Ultraboost 22 Running', 'sku' => 'ADI-UB22', 'price' => 95000, 'stock' => 28, 'description' => 'Ténis de corrida Adidas Ultraboost 22 com tecnologia Boost para máximo retorno de energia.'],
                ['name' => 'Camisa Social Slim Fit Branca', 'sku' => 'MOD-CAM-SL', 'price' => 18500, 'stock' => 60, 'description' => 'Camisa social masculina slim fit em algodão premium, ideal para escritório e eventos formais.'],
                ['name' => 'Vestido Floral Midi Verão', 'sku' => 'MOD-VES-FL', 'price' => 22000, 'stock' => 40, 'featured' => true, 'description' => 'Vestido feminino midi com estampa floral, tecido leve e confortável para o clima tropical.'],
                ['name' => 'Relógio Casio Edifice EFR-S108D', 'sku' => 'CAS-EFR108', 'price' => 45000, 'stock' => 22, 'description' => 'Relógio Casio Edifice analógico com pulseira em aço inoxidável e vidro mineral resistente.'],
                ['name' => 'Mochila Eastpak Padded Pak\'r', 'sku' => 'EAS-PADDED', 'price' => 28000, 'stock' => 50, 'description' => 'Mochila Eastpak Padded Pak\'r clássica, 24 litros, resistente à água e garantia de 30 anos.'],
                ['name' => 'Óculos de Sol Ray-Ban Aviator', 'sku' => 'RAY-AVI-GD', 'price' => 72000, 'stock' => 15, 'description' => 'Óculos de sol Ray-Ban Aviator originais com lentes G-15 e armação dourada clássica.'],
                ['name' => 'Casaco Impermeável North Face', 'sku' => 'TNF-RAIN-M', 'price' => 68000, 'stock' => 20, 'description' => 'Casaco impermeável The North Face com tecnologia DryVent e capuz ajustável.'],
            ],
            'casa-e-jardim' => [
                ['name' => 'Sofá 3 Lugares Linho Bege', 'sku' => 'CAS-SOF-3L', 'price' => 185000, 'stock' => 5, 'featured' => true, 'description' => 'Sofá moderno de 3 lugares revestido em linho bege, estrutura em madeira maciça e almofadas confortáveis.'],
                ['name' => 'Mesa de Jantar Retangular 6 Lugares', 'sku' => 'CAS-MES-6L', 'price' => 125000, 'stock' => 8, 'description' => 'Mesa de jantar em madeira de carvalho para 6 pessoas, acabamento natural e pernas robustas.'],
                ['name' => 'Aspirador Robot Xiaomi S10', 'sku' => 'XIA-S10-ROB', 'price' => 98000, 'stock' => 14, 'description' => 'Aspirador robô Xiaomi com mapeamento a laser, aspiração de 4000Pa e controlo por app.'],
                ['name' => 'Conjunto Panelas Antiaderente 10 Peças', 'sku' => 'CAS-PAN-10', 'price' => 35000, 'stock' => 35, 'description' => 'Conjunto de panelas antiaderentes com 10 peças, compatível com indução e forno.'],
                ['name' => 'Cortador de Relva Elétrico Bosch', 'sku' => 'BOS-LAWN-E', 'price' => 78000, 'stock' => 10, 'description' => 'Cortador de relva elétrico Bosch Rotak 32, leve e eficiente para jardins até 150m².'],
                ['name' => 'Luminária de Chão LED Moderna', 'sku' => 'CAS-LUM-LED', 'price' => 42000, 'stock' => 25, 'description' => 'Luminária de chão com design minimalista, luz LED regulável e base estável em metal.'],
            ],
            'desporto' => [
                ['name' => 'Bicicleta MTB 21 Velocidades', 'sku' => 'DSP-BIKE-MTB', 'price' => 145000, 'stock' => 7, 'featured' => true, 'description' => 'Bicicleta de montanha com quadro em alumínio, 21 velocidades Shimano e travões a disco.'],
                ['name' => 'Halteres Ajustáveis 2x20kg', 'sku' => 'DSP-HAL-20', 'price' => 55000, 'stock' => 18, 'description' => 'Par de halteres ajustáveis de 2x20kg com sistema de bloqueio rápido para treino em casa.'],
                ['name' => 'Bola de Futebol Adidas Tango', 'sku' => 'ADI-TANGO', 'price' => 12000, 'stock' => 80, 'description' => 'Bola de futebol Adidas Tango Rosario oficial, costura termocolada e excelente toque.'],
                ['name' => 'Tapete de Yoga Antiderrapante 6mm', 'sku' => 'DSP-YOGA-6', 'price' => 8500, 'stock' => 55, 'description' => 'Tapete de yoga em TPE ecológico, 6mm de espessura, antiderrapante e com alça de transporte.'],
                ['name' => 'Ténis Asics Gel-Nimbus 25', 'sku' => 'ASI-NIM25', 'price' => 82000, 'stock' => 20, 'description' => 'Ténis de corrida Asics Gel-Nimbus 25 com amortecimento máximo e mesh respirável.'],
                ['name' => 'Kit Musculação Barra + Anilhas 50kg', 'sku' => 'DSP-GYM-50', 'price' => 95000, 'stock' => 12, 'description' => 'Kit completo de musculação com barra olímpica, anilhas até 50kg e trava de segurança.'],
            ],
            'livros' => [
                ['name' => 'O Pequeno Príncipe — Antoine de Saint-Exupéry', 'sku' => 'LIV-PEQ-PR', 'price' => 4500, 'stock' => 100, 'featured' => true, 'description' => 'Edição clássica de O Pequeno Príncipe, um dos livros mais vendidos de todos os tempos. Capa dura.'],
                ['name' => 'Sapiens — Yuval Noah Harari', 'sku' => 'LIV-SAPIENS', 'price' => 6800, 'stock' => 45, 'description' => 'Sapiens: Uma Breve História da Humanidade. Best-seller internacional sobre a evolução da espécie humana.'],
                ['name' => '1984 — George Orwell', 'sku' => 'LIV-1984', 'price' => 4200, 'stock' => 60, 'description' => 'Romance distópico clássico de George Orwell. Edição em português com notas de rodapé.'],
                ['name' => 'Dicionário Houaiss da Língua Portuguesa', 'sku' => 'LIV-HOUAISS', 'price' => 15000, 'stock' => 15, 'description' => 'Dicionário Houaiss da Língua Portuguesa, referência completa com mais de 400.000 verbetes.'],
                ['name' => 'A Culpa é das Estrelas — John Green', 'sku' => 'LIV-CULPA', 'price' => 3800, 'stock' => 70, 'description' => 'Romance juvenil emocionante de John Green. História de amor inesquecível.'],
                ['name' => 'Harry Potter e a Pedra Filosofal', 'sku' => 'LIV-HP1', 'price' => 5500, 'stock' => 55, 'featured' => true, 'description' => 'Primeiro volume da saga Harry Potter de J.K. Rowling. Edição ilustrada em português.'],
            ],
            'beleza' => [
                ['name' => 'Perfume Chanel Nº5 Eau de Parfum 50ml', 'sku' => 'BEL-CHN5-50', 'price' => 125000, 'stock' => 10, 'featured' => true, 'description' => 'Perfume feminino Chanel Nº5 Eau de Parfum 50ml. Fragrância icónica e elegante desde 1921.'],
                ['name' => 'Kit Maquilhagem Profissional 24 Cores', 'sku' => 'BEL-MAQ-24', 'price' => 28000, 'stock' => 30, 'description' => 'Paleta de sombras com 24 cores matte e shimmer, pigmentação intensa e longa duração.'],
                ['name' => 'Creme Hidratante Nivea Soft 300ml', 'sku' => 'BEL-NIV-SOFT', 'price' => 3500, 'stock' => 120, 'description' => 'Creme hidratante Nivea Soft com vitamina E e jojoba. Absorção rápida para rosto e corpo.'],
                ['name' => 'Secador de Cabelo Philips 2100W', 'sku' => 'BEL-PHI-DRY', 'price' => 18500, 'stock' => 25, 'description' => 'Secador Philips 2100W com tecnologia ThermoProtect e difusor incluído.'],
                ['name' => 'Óleo Capilar Moroccanoil Treatment', 'sku' => 'BEL-MOR-OIL', 'price' => 22000, 'stock' => 18, 'description' => 'Tratamento capilar Moroccanoil com óleo de argão puro para cabelos secos e danificados.'],
                ['name' => 'Escova Elétrica Oral-B Pro 3', 'sku' => 'BEL-ORB-PRO3', 'price' => 32000, 'stock' => 22, 'description' => 'Escova de dentes elétrica Oral-B Pro 3 com 3 modos de escovagem e temporizador integrado.'],
            ],
            'brinquedos' => [
                ['name' => 'LEGO City Camião de Bombeiros', 'sku' => 'BRQ-LEG-FIRE', 'price' => 28000, 'stock' => 20, 'featured' => true, 'description' => 'Set LEGO City Camião de Bombeiros com 300 peças, figuras de bombeiros e acessórios. Idade 6+.'],
                ['name' => 'Boneca Barbie Fashionistas', 'sku' => 'BRQ-BARBIE-F', 'price' => 8500, 'stock' => 45, 'description' => 'Boneca Barbie Fashionistas com roupa moderna e articulações móveis. Diversos modelos.'],
                ['name' => 'Carrinho de Controlo Remoto 4x4', 'sku' => 'BRQ-RC-4X4', 'price' => 22000, 'stock' => 30, 'description' => 'Carrinho RC 4x4 escala 1:16 com controlo remoto 2.4GHz e suspensão independente.'],
                ['name' => 'Jogo de Tabuleiro Monopoly Clássico', 'sku' => 'BRQ-MONO-CL', 'price' => 12000, 'stock' => 35, 'description' => 'Monopoly edição clássica em português. O jogo de negócios mais popular do mundo.'],
                ['name' => 'Peluche Urso Grande 80cm', 'sku' => 'BRQ-URSO-80', 'price' => 15000, 'stock' => 25, 'description' => 'Peluche de urso gigante 80cm, macio e hipoalergénico. Presente perfeito para crianças.'],
                ['name' => 'Pista Hot Wheels Super Speed', 'sku' => 'BRQ-HW-SPEED', 'price' => 18500, 'stock' => 28, 'description' => 'Pista Hot Wheels Super Speed com loopings e lançador automático. Inclui 2 carros.'],
            ],
            'automovel' => [
                ['name' => 'Pneu Michelin Primacy 4 205/55 R16', 'sku' => 'AUT-MIC-P4', 'price' => 45000, 'stock' => 40, 'featured' => true, 'description' => 'Pneu Michelin Primacy 4 205/55 R16 com excelente aderência em piso molhado e baixo ruído.'],
                ['name' => 'Bateria Automóvel 60Ah 12V', 'sku' => 'AUT-BAT-60', 'price' => 38000, 'stock' => 25, 'description' => 'Bateria automóvel 60Ah 12V livre de manutenção, compatível com a maioria dos veículos compactos.'],
                ['name' => 'Kit Ferramentas Mecânico 108 Peças', 'sku' => 'AUT-TOOL-108', 'price' => 32000, 'stock' => 18, 'description' => 'Maleta com 108 ferramentas para mecânica automóvel: chaves, catracas, bits e acessórios.'],
                ['name' => 'Tapetes Automóvel Universal 4 Peças', 'sku' => 'AUT-TAP-4P', 'price' => 12000, 'stock' => 50, 'description' => 'Tapetes de borracha universal para automóvel, 4 peças, fáceis de limpar e resistentes.'],
                ['name' => 'Suporte Telemóvel Ventosa para Carro', 'sku' => 'AUT-HOLD-VT', 'price' => 6500, 'stock' => 65, 'description' => 'Suporte universal para telemóvel com ventosa forte e rotação 360°. Compatível com todos os smartphones.'],
                ['name' => 'Cera Polimento Auto Meguiar\'s Gold Class', 'sku' => 'AUT-MEG-WAX', 'price' => 9800, 'stock' => 30, 'description' => 'Cera de polimento Meguiar\'s Gold Class para acabamento espelhado e proteção UV da pintura.'],
            ],
        ];
    }
}
