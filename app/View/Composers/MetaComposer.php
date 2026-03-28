<?php

namespace App\View\Composers;

use App\Models\Comment;
use App\Models\Filling;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MetaComposer
{
    public function __construct(protected Request $request) {}

    public function compose(View $view): void
    {
        $meta = $this->buildMeta();
        $view->with([
            'title'   => $meta['title'],
            'meta'    => $meta,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // Builder
    // ─────────────────────────────────────────────────────────

    private function buildMeta(): array
    {
        $segment1 = $this->request->segment(1);
        $segment2 = $this->request->segment(2);

        return match (true) {
            $segment1 === null         => $this->homeMeta(),
            $segment1 === 'filling'    => $this->fillingMeta($segment2),
            $segment1 === 'product'    => $this->productMeta($segment2),
            $segment1 === 'testimonials' => $this->testimonialsMeta(),
            $segment1 === 'contacts'   => $this->contactsMeta(),
            $segment1 === 'privacy'    => $this->privacyMeta(),
            $segment1 === 'order'      => $this->orderMeta(),
            $segment1 === 'cart'       => $this->cartMeta(),
            default                    => $this->defaults(),
        };
    }

    // ─────────────────────────────────────────────────────────
    // Per-page meta
    // ─────────────────────────────────────────────────────────

    private function homeMeta(): array
    {
        $avgRating = Comment::avg('estimation') ?? 5;
        $reviewCount = Comment::count();

        $jsonLd = [
            $this->localBusinessSchema(),
            $this->webSiteSchema(),
        ];

        if ($reviewCount > 0) {
            $jsonLd[] = $this->aggregateRatingSchema((float) $avgRating, $reviewCount);
        }

        return $this->build(
            title: 'Торти, Капкейки, Бенто на замовлення в Обухові',
            description: 'Замовте авторські торти, капкейки, бенто та кейпопси з натуральних інгредієнтів. '
                . 'Кондитерська майстерня Trufel — солодощі з любов\'ю для кожного свята. м. Обухів.',
            keywords: 'торт на замовлення, капкейки, бенто торт, кейпопси, кондитерська, '
                . 'солодощі на замовлення, Обухів, Київська область',
            ogType: 'website',
            jsonLd: $jsonLd,
        );
    }

    private function fillingMeta(?string $typeId): array
    {
        $type     = $typeId ? Type::find($typeId) : null;
        $typeName = $type?->name ?? 'Каталог';

        // Ukrainian genitive form: "смак вашого торта / капкейків / бенто"
        $genitiveMap = config('seo.type_genitive', []);
        $genitive    = $genitiveMap[$typeName] ?? mb_strtolower($typeName);

        // Type description override: "авторських тортів" / "смачних капкейків"
        $typeDescMap = config('seo.type_descriptions', []);
        $typeDesc    = $typeDescMap[$typeName] ?? mb_strtolower($typeName);

        $count    = $type ? $type->fillings(null)->count() : 0;
        $minPrice = $type
            ? Filling::whereHas('category', fn($q) => $q->where('type_id', $type->id))
                ->min('unit_price')
            : null;

        $priceText = $minPrice ? " від {$minPrice} грн" : '';
        $countText = $count > 0 ? "{$count} варіантів{$priceText}. " : '';

        $jsonLd = $type ? [$this->productListSchema($type)] : [];

        return $this->build(
            title: "Каталог {$typeName}",
            description: "Оберіть смак {$typeDesc}. {$countText}"
                . 'Замовте онлайн у кондитерській Trufel, м. Обухів.',
            keywords: "{$typeName} на замовлення, начинки для {$genitive}, "
                . "смаки {$genitive}, кондитерська Trufel, Обухів",
            ogType: 'website',
            jsonLd: $jsonLd,
        );
    }

    private function productMeta(?string $typeId): array
    {
        $type     = $typeId ? Type::find($typeId) : null;
        $typeName = $type?->name ?? 'Продукція';

        $typeDescMap = config('seo.type_descriptions', []);
        $typeDesc    = $typeDescMap[$typeName] ?? mb_strtolower($typeName);

        $genitiveMap = config('seo.type_genitive', []);
        $genitive    = $genitiveMap[$typeName] ?? mb_strtolower($typeName);

        return $this->build(
            title: "Фото {$typeName} — Портфоліо",
            description: "Перегляньте наші роботи — авторські {$typeDesc} різних дизайнів та оформлень. "
                . 'Індивідуальний декор на замовлення у Trufel, м. Обухів.',
            keywords: "фото {$genitive}, дизайн {$genitive}, портфоліо кондитерської, Trufel, Обухів",
            ogType: 'website',
        );
    }

    private function testimonialsMeta(): array
    {
        $avgRating = Comment::avg('estimation') ?? 5;
        $reviewCount = Comment::count();

        $ratingText = $reviewCount > 0
            ? "Середня оцінка {$avgRating} з 5 ({$reviewCount} відгуків). "
            : '';

        return $this->build(
            title: 'Відгуки клієнтів',
            description: "{$ratingText}Що кажуть наші клієнти про торти та солодощі від Trufel. "
                . 'Залиште свій відгук.',
            keywords: 'відгуки, кондитерська Trufel, торти Обухів, оцінки клієнтів',
            ogType: 'website',
            jsonLd: $reviewCount > 0
                ? [$this->aggregateRatingSchema((float) $avgRating, $reviewCount)]
                : [],
        );
    }

    private function contactsMeta(): array
    {
        return $this->build(
            title: 'Контакти — Кондитерська в Обухові',
            description: 'Контакти кондитерської Trufel. Адреса: Обухів, вул. Дзюбівка 9 . '
                . 'Телефон: +380934978646. Instagram: tru._.fel.',
            keywords: 'контакти, кондитерська Обухів, Trufel адреса, замовити торт Обухів',
            ogType: 'website',
            jsonLd: [$this->localBusinessSchema()],
        );
    }

    private function privacyMeta(): array
    {
        return $this->build(
            title: 'Політика конфіденційності',
            description: 'Політика конфіденційності та обробки персональних даних кондитерської Trufel.',
            keywords: 'політика конфіденційності, Trufel',
            robots: 'noindex, follow',
        );
    }

    private function orderMeta(): array
    {
        return $this->build(
            title: 'Оформлення замовлення',
            description: 'Оформіть замовлення торту або солодощів у кондитерській Trufel.',
            robots: 'noindex, nofollow',
        );
    }

    private function cartMeta(): array
    {
        return $this->build(
            title: 'Кошик',
            description: 'Ваш кошик замовлення у кондитерській Trufel.',
            robots: 'noindex, nofollow',
        );
    }

    private function defaults(): array
    {
        return $this->build(
            title: config('seo.default_title'),
            description: config('seo.default_description'),
            keywords: config('seo.default_keywords'),
        );
    }

    // ─────────────────────────────────────────────────────────
    // Core builder
    // ─────────────────────────────────────────────────────────

    private function build(
        string $title,
        string $description = '',
        string $keywords = '',
        string $ogType = 'website',
        string $robots = 'index, follow',
        array  $jsonLd = [],
    ): array {
        $siteName  = config('seo.site_name', 'Trufel');
        $ogImage   = config('seo.og_image');
        $canonical = $this->request->url();
        $fullOgImage = $ogImage ? url($ogImage) : null;

        return [
            'title'           => $title,
            'full_title'      => $title . config('seo.separator') . $siteName,
            'description'     => $description ?: config('seo.default_description'),
            'keywords'        => $keywords ?: config('seo.default_keywords'),
            'canonical'       => $canonical,
            'robots'          => $robots,
            'og_title'        => $title,
            'og_description'  => $description ?: config('seo.default_description'),
            'og_image'        => $fullOgImage,
            'og_url'          => $canonical,
            'og_type'         => $ogType,
            'og_site_name'    => $siteName,
            'og_locale'       => 'uk_UA',
            'json_ld'         => $jsonLd,
        ];
    }

    // ─────────────────────────────────────────────────────────
    // JSON-LD schemas
    // ─────────────────────────────────────────────────────────

    private function localBusinessSchema(): array
    {
        $b = config('seo.business');

        return [
            '@context' => 'https://schema.org',
            '@type'    => $b['type'],
            'name'     => $b['name'],
            'description' => $b['description'],
            'url'      => config('app.url'),
            'telephone' => $b['phone'],
            'address'  => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $b['address']['street'],
                'addressLocality' => $b['address']['city'],
                'addressRegion'   => $b['address']['region'],
                'postalCode'      => $b['address']['postal'],
                'addressCountry'  => $b['address']['country'],
            ],
            'sameAs'   => $b['social'],
            'image'    => url(config('seo.og_image')),
            'servesCuisine' => 'Кондитерські вироби',
            'priceRange' => '₴₴',
        ];
    }

    private function webSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => config('seo.site_name'),
            'url'      => config('app.url'),
        ];
    }

    private function aggregateRatingSchema(float $rating, int $count): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'LocalBusiness',
            'name'            => config('seo.business.name'),
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => round($rating, 1),
                'reviewCount' => $count,
                'bestRating'  => 5,
                'worstRating' => 1,
            ],
        ];
    }

    private function productListSchema(Type $type): array
    {
        $fillings = Filling::whereHas('category', fn($q) => $q->where('type_id', $type->id))
            ->limit(10)
            ->get();

        $items = $fillings->map(fn($filling, $i) => [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'item'     => [
                '@type'       => 'Product',
                'name'        => $filling->title,
                'description' => $filling->description,
                'offers'      => [
                    '@type'         => 'Offer',
                    'priceCurrency' => 'UAH',
                    'price'         => $filling->unit_price,
                    'availability'  => 'https://schema.org/InStock',
                ],
            ],
        ])->values()->all();

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'name'            => $type->name . ' — каталог начинок',
            'numberOfItems'   => count($items),
            'itemListElement' => $items,
        ];
    }
}
