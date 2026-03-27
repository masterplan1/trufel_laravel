<x-app-layout :is_not_title_page="false">

    {{-- ===== CATEGORY MOSAIC ===== --}}
    @if($menuTypes->isNotEmpty())
    <section class="max-w-5xl mx-auto px-4 pt-10 pb-4">
        <div class="text-center mb-8">
            <h2 class="section-title">Каталог</h2>
            <p class="text-brand-muted text-lg mt-1">Оберіть категорію та знайдіть свій смак</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($menuTypes as $type)
            <a href="{{ route('filling', $type) }}"
                class="group block rounded-2xl overflow-hidden shadow-sm border border-brand-blush hover:shadow-md hover:-translate-y-1 transition-all duration-300 bg-white">
                @if ($type->image)
                    <img src="{{ $type->image }}" alt="{{ $type->name }}"
                        class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <x-img-placeholder class="w-full h-36" />
                @endif
                <div class="py-3 px-3 text-center">
                    <span class="font-kurale text-base text-brand-text group-hover:text-brand-rose transition-colors duration-200">
                        {{ $type->name }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== FEATURED PRODUCTS ===== --}}
    <section class="max-w-5xl mx-auto px-4 pt-16 pb-12">

        <div class="text-center mb-10">
            <h2 class="section-title">Наша продукція</h2>
            <p class="text-brand-muted text-lg mt-1">Обирай смак — і починай своє замовлення</p>
        </div>

        @if($featuredFillings->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($featuredFillings as $filling)
                <div x-data="{ filling: {{ Js::from($filling) }} }" class="card flex flex-col">
                    <div class="relative overflow-hidden">
                        <img class="w-full h-[220px] object-cover hover:scale-105 transition-transform duration-500"
                            src="{{ $filling['image'] }}" alt="{{ $filling['title'] }}" loading="lazy">
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-kurale text-xl mb-1">{{ $filling['title'] }}</h3>
                        <p class="text-brand-rose text-lg font-medium mt-auto pt-2">
                            {{ $filling['unit_price'] }} грн/
                            {{ $filling['type_weight_quantity'] === 'weight' ? 'кг' : 'шт' }}
                        </p>
                        <p class="text-brand-muted text-sm mb-3">
                            від {{ $filling['type_weight_quantity'] === 'weight'
                                ? ($filling['min_weight'] . ' кг')
                                : ($filling['min_quantity'] . ' шт') }}
                        </p>
                        <button @click="$store.cart.handleOpenModal(filling)"
                            class="button !my-0 !mx-0 w-full text-center">
                            Обрати
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('filling', App\Models\Type::first()) }}"
                class="btn-outline inline-block text-lg">
                Весь каталог →
            </a>
        </div>
        @endif
    </section>

    {{-- ===== HOW TO ORDER ===== --}}
    <section class="py-16" style="width:100vw; position:relative; left:50%; right:50%; margin-left:-50vw; margin-right:-50vw; background:#F0DDD9;">
        <div class="max-w-5xl mx-auto px-4">

            <div class="text-center mb-12">
                <h2 class="section-title">Як зробити замовлення</h2>
                <p class="text-brand-muted text-lg mt-1">Три прості кроки до твого ідеального торта</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

                {{-- Step 1 --}}
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-sm mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 text-brand-rose">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                    </div>
                    <span class="text-brand-rose font-caveat text-2xl mb-2">Крок 1</span>
                    <h3 class="font-kurale text-xl mb-2">Обери смак</h3>
                    <p class="text-brand-muted leading-relaxed">
                        Перегляни каталог і підбери начинку, розмір та кількість — все до твого смаку
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-sm mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 text-brand-rose">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </div>
                    <span class="text-brand-rose font-caveat text-2xl mb-2">Крок 2</span>
                    <h3 class="font-kurale text-xl mb-2">Оформи замовлення</h3>
                    <p class="text-brand-muted leading-relaxed">
                        Додай у кошик, вкажи своє ім'я, номер телефону та бажану дату отримання
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-sm mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 text-brand-rose">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <span class="text-brand-rose font-caveat text-2xl mb-2">Крок 3</span>
                    <h3 class="font-kurale text-xl mb-2">Отримай смакоту</h3>
                    <p class="text-brand-muted leading-relaxed">
                        Кондитер підтвердить замовлення і приготує все з любов'ю спеціально для тебе
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS PREVIEW ===== --}}
    @if($recentComments->isNotEmpty())
    <section class="max-w-5xl mx-auto px-4 py-16">

        <div class="text-center mb-10">
            <h2 class="section-title">Відгуки клієнтів</h2>
            <p class="text-brand-muted text-lg mt-1">Що кажуть ті, хто вже скуштував</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($recentComments as $comment)
                <div class="card p-6 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-blush flex items-center justify-center
                            font-kurale text-brand-rose-dark text-lg font-semibold flex-shrink-0">
                            {{ mb_substr($comment->author_name, 0, 1) }}
                        </div>
                        <span class="font-kurale text-lg">{{ $comment->author_name }}</span>
                    </div>
                    <div class="flex gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="{{ $i <= ($comment->estimation ?? 5) ? 'currentColor' : 'none' }}"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-5 h-5 text-brand-rose">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-brand-muted leading-relaxed text-sm line-clamp-3">{{ $comment->description }}</p>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('testimonials') }}" class="btn-outline inline-block text-lg">
                Всі відгуки →
            </a>
        </div>

    </section>
    @endif

</x-app-layout>
