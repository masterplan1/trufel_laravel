<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site-wide SEO defaults
    |--------------------------------------------------------------------------
    */

    'site_name'   => 'Trufel',
    'separator'   => ' | ',

    // Default title used when no page-specific title is set
    'default_title' => 'Trufel — Торти, Капкейки, Бенто на замовлення',

    // Default description
    'default_description' => 'Авторські торти, капкейки, бенто та кейпопси на замовлення. '
        . 'Кондитерська майстерня Trufel — солодощі з любов\'ю для кожного свята. м. Обухів.',

    // Default keywords
    'default_keywords' => 'торт на замовлення, капкейки, бенто торт, кейпопси, '
        . 'кондитерська, солодощі, Обухів, Київська область',

    // OG default image (absolute path from public/)
    'og_image' => '/img/logo-image.jpg',

    /*
    |--------------------------------------------------------------------------
    | Ukrainian genitive forms for product type names
    | Used in SEO descriptions: "Оберіть смак вашого ..."
    | Key = Type name (as stored in DB), value = genitive form
    |--------------------------------------------------------------------------
    */
    'type_genitive' => [
        'Торт'     => 'торта',
        'Капкейки' => 'капкейків',
        'Бенто'    => 'бенто',
        'Кейпопси' => 'кейпопсів',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO descriptions per type (optional override)
    | If not set, auto-generated description is used
    |--------------------------------------------------------------------------
    */
    'type_descriptions' => [
        'Торт'     => 'авторських тортів',
        'Капкейки' => 'смачних капкейків',
        'Бенто'    => 'маленьких бенто-тортів',
        'Кейпопси' => 'кейпопсів',
    ],

    // Business info for structured data
    'business' => [
        'name'        => 'Trufel',
        'type'        => 'Bakery',
        'description' => 'Авторські торти, капкейки, бенто та кейпопси на замовлення у Обухові.',
        'phone'       => '+380934978646',
        'address'     => [
            'street'   => 'вул. Молодіжна, 2',
            'city'     => 'Обухів',
            'region'   => 'Київська область',
            'country'  => 'UA',
            'postal'   => '08700',
        ],
        'social' => [
            'https://www.instagram.com/tru._.fel/',
        ],
    ],

];
