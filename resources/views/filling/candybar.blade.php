<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                {{ $type->name }}
                </x-slot>
                *тут ви можете переглянути можливі варіанти начинок
                для солодощів і вибрати собі щось за смаком.
        </x-title>
        <div x-data="fillingItem({{ json_encode(
            $categories->mapWithKeys(
                fn($category, $key) => [
                    $category->id => [
                        'id' => $category->id,
                        'image' => $category->fillings[0]->image,
                        'title' => $category->name,
                        'unit_price' => $category->fillings[0]->unit_price,
                        'min_quantity' => $category->fillings[0]->min_quantity ?? null,
                        'fillings' => $category->fillings,
                        'type_id' => $type->id,
                        'type_name' => $type->name,
                        'type_weight_quantity' => $type->weight_quantity,
                        'type_is_candybar' => $type->is_candybar,
                    ],
                ],
            ),
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-8 sm:mt-16">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4 mb-10 min-h-[460px] sm:min-h-[400px]">
                @foreach ($categories as $category)
                    <div class="card flex flex-col">
                        <div class="relative overflow-hidden">
                            <div
                                class="opacity-0 hover:opacity-100 transition-all duration-300 absolute
                                inset-0 z-10 bg-brand-text/80 text-white p-4 overflow-hidden rounded-t-2xl">
                                <h3 class="text-xl font-semibold underline mb-2">{{ $category->name }}</h3>
                                @foreach ($category->fillings as $filling)
                                    <p class="text-left text-sm leading-relaxed">{{ $filling->title }}</p>
                                @endforeach
                            </div>
                            <img class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] object-cover
                                hover:scale-105 transition-transform duration-500 rounded-t-2xl"
                                src="{{ $category->fillings[0]->image }}" alt="{{ $category->name }}" loading="lazy">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h4 class="text-xl mb-1">{{ $category->name }}</h4>
                            <div class="flex justify-between items-center mt-auto pt-2 mb-3">
                                <p class="text-brand-rose text-xl font-medium">
                                    {{ $category->fillings[0]->unit_price }} грн/шт
                                </p>
                                <p class="text-brand-muted text-sm">від {{ $category->fillings[0]->min_quantity }} шт.</p>
                            </div>
                            <button @click="$store.cart.handleOpenModal(fillings[{{ $category->id }}])"
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
                                    <div
                                        class="opacity-0 hover:opacity-100 transition-all duration-300 absolute
                                        inset-0 z-10 bg-brand-text/80 text-white p-4 overflow-hidden rounded-t-2xl">
                                        <h3 class="text-xl font-semibold underline mb-2" x-text="newFilling.title"></h3>
                                        <template x-for="f in newFilling.fillings">
                                            <p class="text-left text-sm leading-relaxed" x-text="f.description"></p>
                                        </template>
                                    </div>
                                    <img class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] object-cover
                                        hover:scale-105 transition-transform duration-500 rounded-t-2xl"
                                        :src="prepareFillingForCandybar(newFilling).image" alt="" loading="lazy">
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <h4 class="text-xl mb-1" x-text="newFilling.title"></h4>
                                    <div class="flex justify-between items-center mt-auto pt-2 mb-3">
                                        <p class="text-brand-rose text-xl font-medium">
                                            <span x-text="prepareFillingForCandybar(newFilling).unit_price"></span> грн/шт
                                        </p>
                                        <p class="text-brand-muted text-sm">від
                                            <span x-text="chooseWeightQuantity(prepareFillingForCandybar(newFilling))"></span>
                                        </p>
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
