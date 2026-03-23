<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filling;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    const FILLING_IMAGE = 'images/rrJZFLLTP0z9SJlo-1774207294/banan_gauda';
    const PRODUCT_IMAGE = 'images/DeTLVygtH2B3Foyv-1774207240/product_image';

    // Начинки для Торт → Бісквітні (category_id=1)
    const BISKVIТNI_FILLINGS = [
        ['title' => 'Шоколад-вишня',       'desc' => 'Ніжний шоколадний бісквіт з кислинкою свіжої вишні та шоколадним ганашем.',         'price' => 450],
        ['title' => 'Ванільний крем-чіз',   'desc' => 'Класичний ванільний бісквіт з повітряним кремом на основі вершкового сиру.',         'price' => 420],
        ['title' => 'Полуниця-вершки',      'desc' => 'Легкий бісквіт просочений сиропом, з прошарком свіжої полуниці та збитими вершками.', 'price' => 480],
        ['title' => 'Банан-карамель',       'desc' => 'Соковитий бісквіт з бананом та солоною карамеллю — справжня насолода.',              'price' => 440],
        ['title' => 'Горіх-шоколад',        'desc' => 'Шоколадний бісквіт з хрустким фундуком та праліне. Улюбленець шоколадоманів.',       'price' => 500],
        ['title' => 'Лимонний меренг',      'desc' => 'Освіжаючий лимонний курд між шарами бісквіту з хмаринкою меренги.',                  'price' => 460],
        ['title' => 'Чорниця-сир',          'desc' => 'Ніжний сирний крем з ягодами чорниці на пухкому ванільному бісквіті.',               'price' => 470],
        ['title' => 'Персик-йогурт',        'desc' => 'Літній смак: стиглий персик з легким йогуртовим кремом.',                            'price' => 430],
        ['title' => 'Малина-базилік',       'desc' => 'Незвичайне поєднання: кисла малина та аромат свіжого базиліку.',                     'price' => 490],
        ['title' => 'Медовик-горіх',        'desc' => 'Медяні коржі з горіховим кремом — класика з сучасним акцентом.',                    'price' => 410],
    ];

    // Начинки для Торт → Мусові (category_id=2)
    const MUSOVI_FILLINGS = [
        ['title' => 'Манго-маракуя',        'desc' => 'Тропічний мус з манго та маракуєю на хрустій основі.',                               'price' => 550],
        ['title' => 'Шоколадний мус',       'desc' => 'Насичений мус з чорного шоколаду 70% з хрустким праліне.',                           'price' => 520],
        ['title' => 'Полуничний мус',       'desc' => 'Ніжний мус зі свіжої полуниці з легким ванільним ароматом.',                         'price' => 530],
        ['title' => 'Кава-шоколад',         'desc' => 'Для любителів кави: еспресо-мус з шаром молочного шоколаду.',                         'price' => 540],
        ['title' => 'Карамель-груша',       'desc' => 'Солодка карамель з нотками соковитої груші в муссовому вигляді.',                    'price' => 560],
        ['title' => 'Ягідний мус',          'desc' => 'Мікс ягід: малина, смородина та ожина в легкому муссовому шарі.',                    'price' => 545],
        ['title' => 'Лайм-кокос',           'desc' => 'Тропічний коктейль: освіжаючий лайм та вершковий кокос.',                           'price' => 570],
        ['title' => 'Вишня-мигдаль',        'desc' => 'Вишневе компоте з мигдальним муссом та дакуазом.',                                   'price' => 555],
        ['title' => 'Малина-лаванда',       'desc' => 'Вишуканий мус з малини та прованської лаванди — справжня елегантність.',             'price' => 580],
        ['title' => 'Апельсин-шоколад',     'desc' => 'Класичне поєднання: гіркий шоколад та свіжий апельсин.',                            'price' => 535],
    ];

    // Начинки для Бенто → Класичні
    const BENTO_CLASSIC_FILLINGS = [
        ['title' => 'Шоколадний',           'desc' => 'Шоколадний бісквіт з шоколадним кремом — для справжніх фанатів шоколаду.',          'price' => 250],
        ['title' => 'Ванільний',            'desc' => 'Ніжний ванільний бісквіт зі збитим вершковим кремом.',                               'price' => 230],
        ['title' => 'Червоний оксамит',     'desc' => 'Вологий бісквіт яскравого кольору з ніжним крем-чізом.',                             'price' => 270],
        ['title' => 'Морквяний',            'desc' => 'Соковитий морквяний торт з корицею та вершковим сиром.',                             'price' => 240],
        ['title' => 'Лимонний',             'desc' => 'Освіжаючий лимонний бісквіт з лимонним кремом та цедрою.',                          'price' => 260],
    ];

    // Начинки для Бенто → Фруктові
    const BENTO_FRUIT_FILLINGS = [
        ['title' => 'Полуничний',           'desc' => 'Ніжний бісквіт з кремом і шматочками свіжої полуниці.',                              'price' => 265],
        ['title' => 'Малиновий',            'desc' => 'Яскравий малиновий конфітюр між шарами повітряного бісквіту.',                       'price' => 275],
        ['title' => 'Персиковий',           'desc' => 'Літній персик з легким йогуртовим кремом у маленькому форматі.',                     'price' => 255],
        ['title' => 'Чорниця-йогурт',       'desc' => 'Свіжа чорниця та йогуртовий мус — легкий і корисний смак.',                         'price' => 270],
        ['title' => 'Маракуя',              'desc' => 'Екзотичний смак маракуї з ванільним кремом та хрусткою основою.',                    'price' => 280],
    ];

    // Категорії для Капкейки (candybar)
    const CUPCAKE_CATEGORIES = [
        ['name' => 'Шоколадні',   'fillings' => [
            ['title' => 'Шоколадний ганаш',     'desc' => 'Насичений шоколадний кекс з кремом на основі темного шоколаду.',    'price' => 55],
            ['title' => 'Шоколад-вишня',        'desc' => 'Шоколадний кекс із вишневою начинкою всередині.',                   'price' => 60],
        ]],
        ['name' => 'Ванільні',    'fillings' => [
            ['title' => 'Ванільний крем-чіз',   'desc' => 'Класичний ванільний кекс з ніжним кремом на основі вершкового сиру.','price' => 50],
            ['title' => 'Ванільна карамель',    'desc' => 'Ванільний кекс з рідкою карамеллю всередині.',                      'price' => 58],
        ]],
        ['name' => 'Полуничні',   'fillings' => [
            ['title' => 'Полунична конфета',    'desc' => 'Ніжний кекс із свіжою полуницею та рожевим кремом.',                'price' => 62],
        ]],
        ['name' => 'Лимонні',     'fillings' => [
            ['title' => 'Лимонний меренг',      'desc' => 'Освіжаючий лимонний кекс з меренговою шапочкою.',                   'price' => 65],
        ]],
        ['name' => 'Карамельні',  'fillings' => [
            ['title' => 'Солона карамель',      'desc' => 'Ніжний кекс з кремом солоної карамелі — неможливо зупинитись.',     'price' => 60],
        ]],
    ];

    // Категорії для Кейпопси (candybar)
    const CAKEPOPS_CATEGORIES = [
        ['name' => 'Шоколадні',   'fillings' => [
            ['title' => 'Шоколадний кейпопс',   'desc' => 'Шоколадний кекс на паличці в глазурі з молочного шоколаду.',        'price' => 40],
            ['title' => 'Подвійний шоколад',    'desc' => 'Для шоколадоманів: темна глазур та шоколадна начинка.',              'price' => 45],
        ]],
        ['name' => 'Полуничні',   'fillings' => [
            ['title' => 'Полуничний кейпопс',   'desc' => 'Рожевий кейпопс із полуничним джемом всередині.',                   'price' => 42],
        ]],
        ['name' => 'Ванільні',    'fillings' => [
            ['title' => 'Ванільний кейпопс',    'desc' => 'Класичний ванільний кекс у білій шоколадній глазурі.',               'price' => 38],
        ]],
        ['name' => 'Горіхові',    'fillings' => [
            ['title' => 'Фундук-шоколад',       'desc' => 'Фундукова начинка в шоколадній глазурі — смак пральне.',             'price' => 48],
        ]],
        ['name' => 'Банан-шоколад', 'fillings' => [
            ['title' => 'Банановий кейпопс',    'desc' => 'Банановий мус з шоколадною глазурю — несподівано смачно.',          'price' => 44],
        ]],
    ];

    public function run(): void
    {
        $this->command->info('Seeding fillings...');

        // ─── Торт: Бісквітні (category_id=1) ───
        foreach (self::BISKVIТNI_FILLINGS as $data) {
            Filling::create([
                'title'       => $data['title'],
                'description' => $data['desc'],
                'image'       => self::FILLING_IMAGE,
                'unit_price'  => $data['price'],
                'min_weight'  => 1,
                'min_quantity'=> null,
                'category_id' => 1,
            ]);
        }

        // ─── Торт: Мусові (category_id=2) ───
        foreach (self::MUSOVI_FILLINGS as $data) {
            Filling::create([
                'title'       => $data['title'],
                'description' => $data['desc'],
                'image'       => self::FILLING_IMAGE,
                'unit_price'  => $data['price'],
                'min_weight'  => 1,
                'min_quantity'=> null,
                'category_id' => 2,
            ]);
        }

        // ─── Бенто: нові категорії + начинки ───
        $bentoType = Type::find(3);
        if ($bentoType) {
            $bentoClassic = Category::create(['name' => 'Класичні', 'type_id' => 3]);
            foreach (self::BENTO_CLASSIC_FILLINGS as $data) {
                Filling::create([
                    'title'       => $data['title'],
                    'description' => $data['desc'],
                    'image'       => self::FILLING_IMAGE,
                    'unit_price'  => $data['price'],
                    'min_weight'  => null,
                    'min_quantity'=> 1,
                    'category_id' => $bentoClassic->id,
                ]);
            }

            $bentoFruit = Category::create(['name' => 'Фруктові', 'type_id' => 3]);
            foreach (self::BENTO_FRUIT_FILLINGS as $data) {
                Filling::create([
                    'title'       => $data['title'],
                    'description' => $data['desc'],
                    'image'       => self::FILLING_IMAGE,
                    'unit_price'  => $data['price'],
                    'min_weight'  => null,
                    'min_quantity'=> 1,
                    'category_id' => $bentoFruit->id,
                ]);
            }
        }

        // ─── Капкейки: candybar категорії з начинками ───
        $cupcakeType = Type::find(2);
        if ($cupcakeType) {
            foreach (self::CUPCAKE_CATEGORIES as $catData) {
                $cat = Category::create(['name' => $catData['name'], 'type_id' => 2]);
                foreach ($catData['fillings'] as $data) {
                    Filling::create([
                        'title'       => $data['title'],
                        'description' => $data['desc'],
                        'image'       => self::FILLING_IMAGE,
                        'unit_price'  => $data['price'],
                        'min_weight'  => null,
                        'min_quantity'=> 6,
                        'category_id' => $cat->id,
                    ]);
                }
            }
        }

        // ─── Кейпопси: candybar категорії з начинками ───
        $cakepopsType = Type::find(4);
        if ($cakepopsType) {
            foreach (self::CAKEPOPS_CATEGORIES as $catData) {
                $cat = Category::create(['name' => $catData['name'], 'type_id' => 4]);
                foreach ($catData['fillings'] as $data) {
                    Filling::create([
                        'title'       => $data['title'],
                        'description' => $data['desc'],
                        'image'       => self::FILLING_IMAGE,
                        'unit_price'  => $data['price'],
                        'min_weight'  => null,
                        'min_quantity'=> 10,
                        'category_id' => $cat->id,
                    ]);
                }
            }
        }

        $this->command->info('Fillings: ' . Filling::count() . ' total');

        // ─── Продукти (40 шт по 10 на кожен тип) ───
        $this->command->info('Seeding products...');

        $allCategories = Category::all()->groupBy('type_id');

        foreach (Type::all() as $type) {
            $typeCategories = $allCategories->get($type->id);
            if (!$typeCategories || $typeCategories->isEmpty()) {
                continue;
            }

            // Розподіляємо 10 продуктів по категоріях типу
            $categoryList = $typeCategories->values();
            $count = $categoryList->count();

            for ($i = 0; $i < 10; $i++) {
                $cat = $categoryList[$i % $count];
                Product::create([
                    'image'       => self::PRODUCT_IMAGE,
                    'category_id' => $cat->id,
                ]);
            }
        }

        $this->command->info('Products: ' . Product::count() . ' total');
        $this->command->info('Done!');
    }
}
