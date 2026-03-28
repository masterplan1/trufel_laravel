<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filling;
use App\Models\Type;
use Illuminate\Database\Seeder;

class CandybarFakeDataSeeder extends Seeder
{
    // Існуючий шлях до фото (беремо з таблиці fillings)
    private const IMG = 'images/rrJZFLLTP0z9SJlo-1774207294/banan_gauda';

    public function run(): void
    {
        // Структура: типи кендібару
        // 'single' => один рядок [назва, ціна, мін_к-сть, опис]
        // 'multi'  => масив категорій, кожна з масивом начинок
        $types = [

            // 1. Льодяники — простий тип: 1 категорія, 1 начинка
            [
                'name'           => 'Льодяники',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Льодяник',
                        'fillings'=> [
                            ['title'=>'Льодяник полуничний','unit_price'=>45,'min_quantity'=>10,'description'=>'Яскраві фруктові льодяники на паличці з натуральним полуничним смаком.'],
                        ],
                    ],
                ],
            ],

            // 2. Зефір — простий: 1 категорія, 2 начинки
            [
                'name'           => 'Зефір',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Зефір',
                        'fillings'=> [
                            ['title'=>'Зефір ванільний','unit_price'=>30,'min_quantity'=>12,'description'=>'Повітряний домашній зефір з ароматом натуральної ванілі.'],
                            ['title'=>'Зефір малиновий','unit_price'=>35,'min_quantity'=>12,'description'=>'Ніжний зефір з яскравим малиновим джемом усередині.'],
                        ],
                    ],
                ],
            ],

            // 3. Мармелад — простий: 1 категорія, 1 начинка
            [
                'name'           => 'Мармелад',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Мармелад',
                        'fillings'=> [
                            ['title'=>'Фруктовий мармелад','unit_price'=>25,'min_quantity'=>20,'description'=>'Різнобарвний желейний мармелад із натуральними фруктовими смаками.'],
                        ],
                    ],
                ],
            ],

            // 4. Макаруни — складний: 3 категорії, 2-3 начинки
            [
                'name'           => 'Макаруни',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Класичні',
                        'fillings'=> [
                            ['title'=>'Макарун ванільний','unit_price'=>65,'min_quantity'=>6,'description'=>'Класичний французький макарун з вершковим ванільним ганашем.'],
                            ['title'=>'Макарун фісташковий','unit_price'=>70,'min_quantity'=>6,'description'=>'Ніжний макарун з фісташковим кремом та хрустким мигдальним тістом.'],
                        ],
                    ],
                    [
                        'name'    => 'Шоколадні',
                        'fillings'=> [
                            ['title'=>'Макарун чорний шоколад','unit_price'=>70,'min_quantity'=>6,'description'=>'Інтенсивний шоколадний макарун з темним ганашем 72%.'],
                            ['title'=>'Макарун Raffaello','unit_price'=>72,'min_quantity'=>6,'description'=>'Кокосовий макарун з мигдальним кремом у стилі Raffaello.'],
                        ],
                    ],
                    [
                        'name'    => 'Фруктові',
                        'fillings'=> [
                            ['title'=>'Макарун полуниця-базилік','unit_price'=>68,'min_quantity'=>6,'description'=>'Свіжий смак полуниці з нотками базиліку — нестандартне поєднання.'],
                            ['title'=>'Макарун манго-маракуйя','unit_price'=>72,'min_quantity'=>6,'description'=>'Тропічний макарун з кремом із манго та маракуйї.'],
                            ['title'=>'Макарун лимонний','unit_price'=>65,'min_quantity'=>6,'description'=>'Освіжаючий макарун з лимонним курдом.'],
                        ],
                    ],
                ],
            ],

            // 5. Трюфелі — два варіанти: 2 категорії
            [
                'name'           => 'Трюфелі',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Шоколадні',
                        'fillings'=> [
                            ['title'=>'Трюфель класичний','unit_price'=>55,'min_quantity'=>8,'description'=>'Ручний шоколадний трюфель з ніжним ганашем всередині.'],
                            ['title'=>'Трюфель кавовий','unit_price'=>58,'min_quantity'=>8,'description'=>'Трюфель з насиченим кавовим ганашем та посипкою з какао.'],
                        ],
                    ],
                    [
                        'name'    => 'Горіхові',
                        'fillings'=> [
                            ['title'=>'Трюфель фундук-карамель','unit_price'=>62,'min_quantity'=>8,'description'=>'Хрусткий трюфель із карамелізованим фундуком у молочному шоколаді.'],
                            ['title'=>'Трюфель мигдаль-апельсин','unit_price'=>65,'min_quantity'=>8,'description'=>'Трюфель з мигдальним праліне та цедрою апельсина.'],
                        ],
                    ],
                ],
            ],

            // 6. Тістечка — 3 категорії, різна кількість начинок
            [
                'name'           => 'Тістечка',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Еклери',
                        'fillings'=> [
                            ['title'=>'Еклер ванільний','unit_price'=>75,'min_quantity'=>5,'description'=>'Класичний еклер з ніжним заварним кремом і глазур\'ю.'],
                            ['title'=>'Еклер шоколадний','unit_price'=>80,'min_quantity'=>5,'description'=>'Еклер з насиченим шоколадним кремом та дзеркальною глазур\'ю.'],
                        ],
                    ],
                    [
                        'name'    => 'Профітролі',
                        'fillings'=> [
                            ['title'=>'Профітроль вершковий','unit_price'=>55,'min_quantity'=>8,'description'=>'Маленькі профітролі зі збитими вершками та карамельним соусом.'],
                        ],
                    ],
                    [
                        'name'    => 'Міні-тарти',
                        'fillings'=> [
                            ['title'=>'Тарт лимонний','unit_price'=>90,'min_quantity'=>4,'description'=>'Крихкий тарт із лимонним курдом та меренгою.'],
                            ['title'=>'Тарт ягідний','unit_price'=>95,'min_quantity'=>4,'description'=>'Тарт із вершковим кремом та сезонними ягодами.'],
                        ],
                    ],
                ],
            ],

            // 7. Печиво — 2 категорії
            [
                'name'           => 'Печиво',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Вершкове',
                        'fillings'=> [
                            ['title'=>'Печиво сабле','unit_price'=>35,'min_quantity'=>10,'description'=>'Розсипчасте французьке сабле з вершковим маслом і ваніллю.'],
                            ['title'=>'Печиво лінцер','unit_price'=>40,'min_quantity'=>10,'description'=>'Австрійське лінцерське печиво з малиновим джемом.'],
                        ],
                    ],
                    [
                        'name'    => 'Імбирне',
                        'fillings'=> [
                            ['title'=>'Імбирне печиво класичне','unit_price'=>38,'min_quantity'=>10,'description'=>'Ароматне імбирне печиво з корицею та мускатним горіхом.'],
                            ['title'=>'Імбирне печиво з глазур\'ю','unit_price'=>50,'min_quantity'=>6,'description'=>'Прикрашене розписне імбирне печиво — ідеально як подарунок.'],
                        ],
                    ],
                ],
            ],

            // 8. Пряники — простий: 1 категорія
            [
                'name'           => 'Пряники',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Медові',
                        'fillings'=> [
                            ['title'=>'Медовий пряник','unit_price'=>42,'min_quantity'=>8,'description'=>'М\'який медово-пряний пряник з начинкою з вареного згущеного молока.'],
                            ['title'=>'Розписний пряник','unit_price'=>60,'min_quantity'=>6,'description'=>'Декоративний пряник з кольоровою глазур\'ю під ваш стиль свята.'],
                        ],
                    ],
                ],
            ],

            // 9. Карамель — 2 категорії
            [
                'name'           => 'Карамель',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'М\'яка карамель',
                        'fillings'=> [
                            ['title'=>'Карамель солона','unit_price'=>48,'min_quantity'=>10,'description'=>'Ніжна солона карамель ручної роботи з морською сіллю.'],
                            ['title'=>'Карамель вершкова','unit_price'=>45,'min_quantity'=>10,'description'=>'Класична вершкова карамель без зайвої солодості.'],
                        ],
                    ],
                    [
                        'name'    => 'Карамельні яблука',
                        'fillings'=> [
                            ['title'=>'Яблуко в карамелі','unit_price'=>85,'min_quantity'=>3,'description'=>'Свіже яблуко в хрусткій карамелі — улюблений ярмарковий смак.'],
                        ],
                    ],
                ],
            ],

            // 10. Шоколадні цукерки — 3 категорії
            [
                'name'           => 'Шоколадні цукерки',
                'weight_quantity'=> 'quantity',
                'categories'     => [
                    [
                        'name'    => 'Молочний шоколад',
                        'fillings'=> [
                            ['title'=>'Цукерка пралине','unit_price'=>52,'min_quantity'=>8,'description'=>'Шоколадна цукерка з горіховим пралине у молочному шоколаді.'],
                        ],
                    ],
                    [
                        'name'    => 'Темний шоколад',
                        'fillings'=> [
                            ['title'=>'Цукерка кавова','unit_price'=>55,'min_quantity'=>8,'description'=>'Гірка шоколадна цукерка з кавовою ганашем.'],
                            ['title'=>'Цукерка ромова','unit_price'=>58,'min_quantity'=>8,'description'=>'Темний шоколад із ромовою начинкою та родзинками.'],
                        ],
                    ],
                    [
                        'name'    => 'Білий шоколад',
                        'fillings'=> [
                            ['title'=>'Цукерка малина-білий шоколад','unit_price'=>60,'min_quantity'=>8,'description'=>'Ніжний білий шоколад з кислинкою малинового конфі.'],
                            ['title'=>'Цукерка лайм-кокос','unit_price'=>62,'min_quantity'=>8,'description'=>'Тропічне поєднання білого шоколаду з кокосом та лаймом.'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($types as $typeData) {
            $type = Type::firstOrCreate(
                ['name' => $typeData['name']],
                [
                    'weight_quantity'   => $typeData['weight_quantity'],
                    'is_candybar'       => true,
                    'is_candybar_group' => false,
                    'image'             => null,
                ]
            );

            foreach ($typeData['categories'] as $catData) {
                $category = Category::firstOrCreate(
                    ['name' => $catData['name'], 'type_id' => $type->id]
                );

                foreach ($catData['fillings'] as $fillingData) {
                    Filling::firstOrCreate(
                        ['title' => $fillingData['title'], 'category_id' => $category->id],
                        [
                            'type_id'      => $type->id,
                            'description'  => $fillingData['description'],
                            'unit_price'   => $fillingData['unit_price'],
                            'min_quantity' => $fillingData['min_quantity'],
                            'min_weight'   => null,
                            'image'        => self::IMG,
                        ]
                    );
                }
            }
        }
    }
}
