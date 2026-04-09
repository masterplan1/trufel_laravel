<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                {{ $type->name }}
            </x-slot>
            Оберіть начинку і додайте до кошика — ми приготуємо все з любов'ю.
        </x-title>

        {{-- ===== PHOTO ACCORDION ===== --}}
        @if($previewProducts->isNotEmpty())
        <div x-data="{ open: window.innerWidth >= 768 }" class="mb-8 px-4">

            {{-- Toggle button --}}
            <button @click="open = !open"
                class="flex items-center gap-2 mx-auto text-brand-muted hover:text-brand-rose transition-colors duration-200 mb-3 text-base">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <span x-text="open ? 'Сховати фото робіт' : 'Фото робіт ({{ $previewProducts->count() }})'"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            {{-- Photo grid --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-2">
                    @foreach($previewProducts as $product)
                        <div class="overflow-hidden rounded-xl aspect-square">
                            <img src="{{ $product->image }}" alt="{{ $type->name }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('product', $type) }}"
                    class="text-brand-muted hover:text-brand-rose text-sm transition-colors duration-200">
                    Всі фото робіт →
                </a>
            </div>

        </div>
        @endif

        {{-- ===== FILLINGS ===== --}}
        <div x-data="fillingItem({{ json_encode(
            $fillings->mapWithKeys(
                fn($filling, $key) => [
                    $filling->id => [
                        'id' => $filling->id,
                        'image' => $filling->image,
                        'title' => $filling->title,
                        'unit_price' => $filling->unit_price,
                        'min_weight' => $filling->min_weight ?? null,
                        'min_quantity' => $filling->min_quantity ?? null,
                        'type_id' => $type->id,
                        'type_name' => $type->name,
                        'type_weight_quantity' => $type->weight_quantity,
                        'type_is_candybar' => false,
                    ],
                ],
            ),
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-4 sm:mt-8">

            {{-- Category filters --}}
            @if (count($categories) > 1)
                <div class="flex justify-center gap-3 flex-wrap mb-8 px-4">
                    <button @click="selectCategory(0)"
                        class="px-5 py-2 rounded-full border transition-colors duration-200 text-sm sm:text-base
                        hover:bg-brand-rose hover:text-white hover:border-brand-rose"
                        :class="activeClassCategory === null
                            ? 'bg-brand-rose text-white border-brand-rose'
                            : 'border-brand-muted text-brand-muted'">
                        Весь асортимент
                    </button>
                    @foreach ($categories as $key => $category)
                        <button @click="selectCategory({{ $category->id }}, {{ $key }})"
                            class="px-5 py-2 rounded-full border transition-colors duration-200 text-sm sm:text-base
                            hover:bg-brand-rose hover:text-white hover:border-brand-rose"
                            :class="activeClassCategory === {{ $key }}
                                ? 'bg-brand-rose text-white border-brand-rose'
                                : 'border-brand-muted text-brand-muted'">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Fillings grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 mb-10 min-h-[460px]">

                @foreach ($fillings as $filling)
                    <div x-show="!categoryWasSelected" class="card flex flex-col">
                        <div class="relative overflow-hidden">
                            <div class="opacity-0 hover:opacity-100 transition-all duration-300 absolute
                                inset-0 z-10 bg-brand-text/80 text-white p-4 overflow-hidden rounded-t-2xl">
                                <h3 class="text-xl font-semibold underline mb-2">{{ $filling->title }}</h3>
                                <p class="text-left text-sm leading-relaxed whitespace-pre-line">{{ $filling->description }}</p>
                            </div>
                            <img class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] object-cover
                                hover:scale-105 transition-transform duration-500"
                                src="{{ $filling->image }}" alt="{{ $filling->title }}" loading="lazy">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h4 class="text-xl mb-1">{{ $filling->title }}</h4>
                            <div class="flex justify-between items-center mt-auto pt-2 mb-3">
                                <p class="text-brand-rose text-xl font-medium">{{ $filling->unit_price }} грн/
                                    {{ $type->weight_quantity === 'weight' ? 'кг' : 'шт' }}</p>
                                <p class="text-brand-muted text-sm">від <?php
                                    echo $type->weight_quantity === 'weight'
                                        ? $filling->min_weight . ' кг'
                                        : $filling->min_quantity . ' шт';
                                ?></p>
                            </div>
                            <button @click="$store.cart.handleOpenModal(fillings[{{ $filling->id }}])"
                                class="button !my-0 !mx-0 w-full">
                                Обрати
                            </button>
                        </div>
                    </div>
                @endforeach

                <template x-if="additionFillings.length">
                    <template x-for="newFilling in additionFillings" :key="newFilling.id">
                        <div x-data="{ shown: false }" x-intersect.full="shown = true">
                            <div x-show="shown" x-transition class="card flex flex-col">
                                <div class="relative overflow-hidden">
                                    <div class="opacity-0 hover:opacity-100 transition-all duration-300 absolute
                                        inset-0 z-10 bg-brand-text/80 text-white p-4 overflow-hidden rounded-t-2xl">
                                        <h3 class="text-xl font-semibold underline mb-2" x-text="newFilling.title"></h3>
                                        <p class="text-left text-sm leading-relaxed whitespace-pre-line" x-text="newFilling.description"></p>
                                    </div>
                                    <img class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] object-cover
                                        hover:scale-105 transition-transform duration-500"
                                        :src="newFilling.image" alt="" loading="lazy">
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="text-xl mb-1" x-text="newFilling.title"></h4>
                                    <div class="flex justify-between items-center mt-auto pt-2 mb-3">
                                        <p class="text-brand-rose text-xl font-medium">
                                            <span x-text="newFilling.unit_price"></span> грн/<span x-text="chooseWeightQuantity(newFilling) ? 'кг' : 'шт'"></span>
                                        </p>
                                        <p class="text-brand-muted text-sm">від <span x-text="chooseWeightQuantity(newFilling)"></span></p>
                                    </div>
                                    <button @click="$store.cart.handleOpenModal(newFilling)"
                                        class="button !my-0 !mx-0 w-full">
                                        Обрати
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>

            </div>

            {{-- Load more --}}
            <div x-show="countHandler" class="flex items-center justify-center mb-14 px-4">
                <span class="block border border-brand-blush w-full"></span>
                <button @click="addFillings"
                    class="min-w-[200px] px-6 py-2 border border-brand-muted text-brand-muted rounded-full
                    hover:bg-brand-rose hover:text-white hover:border-brand-rose
                    transition-colors duration-200 text-base mx-4 whitespace-nowrap">
                    Більше
                </button>
                <span class="block border border-brand-blush w-full"></span>
            </div>

        </div>
    </section>
</x-app-layout>
