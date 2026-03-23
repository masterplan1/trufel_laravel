<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                {{ $type->name }}
                </x-slot>
                *тут ви можете обрати оформлення за вподобанням
        </x-title>
        <div x-data="productItem({{ json_encode(
            $products->mapWithKeys(
                fn($product, $key) => [
                    $product->id => [
                        'id' => $product->id,
                        'image' => $product->image,
                    ],
                ],
            ),
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-8 sm:mt-16 px-4">
            @include('product.modal-zoom')

            @if (count($categories) > 1 && !$type->is_candybar)
                <div class="flex justify-center gap-3 flex-wrap mb-8">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10 min-h-[460px] sm:min-h-[400px]">
                @foreach ($products as $product)
                    <div x-show="!categoryWasSelected" class="relative overflow-hidden rounded-2xl aspect-square group">
                        <div
                            class="opacity-0 group-hover:opacity-100 transition-all duration-300 absolute
                            inset-0 z-10 flex items-center justify-center bg-brand-text/40 rounded-2xl">
                            <button @click="zoomImage($el)"
                                class="w-14 h-14 flex items-center justify-center bg-white/20 backdrop-blur-sm
                                rounded-full text-white hover:bg-white/40 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </div>
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            src="{{ $product->image }}" alt="" loading="lazy">
                    </div>
                @endforeach

                <template x-if="additionProducts.length">
                    <template x-for="newProduct in additionProducts" :key="newProduct.id">
                        <div x-data="{ shown: false }" x-intersect.full="shown = true">
                            <div x-show="shown" x-transition
                                class="relative overflow-hidden rounded-2xl aspect-square group">
                                <div
                                    class="opacity-0 group-hover:opacity-100 transition-all duration-300 absolute
                                    inset-0 z-10 flex items-center justify-center bg-brand-text/40 rounded-2xl">
                                    <button @click="zoomImage($el)"
                                        class="w-14 h-14 flex items-center justify-center bg-white/20 backdrop-blur-sm
                                        rounded-full text-white hover:bg-white/40 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </button>
                                </div>
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    :src="newProduct.image" alt="" loading="lazy">
                            </div>
                        </div>
                    </template>
                </template>
            </div>

            <div x-show="countHandler" class="flex items-center justify-center mb-14">
                <span class="block border border-brand-blush w-full"></span>
                <button @click="addProducts"
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
