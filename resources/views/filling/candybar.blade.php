<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                {{ $type->name }}
                </x-slot>
                *тут ви можете переглянути
                можливі варіанти начинок
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
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-10 sm:mt-20">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 mb-10 min-h-[460px] sm:min-h-[400px]">
                @foreach ($categories as $category)
                    <div class="px-4 mb-6">
                        <div class="relative">
                            <div
                                class="opacity-0 hover:opacity-100 transition-all absolute 
                              top-0 left-0 w-full h-full z-10 bg-gray-500/80 rounded-md text-white p-3 overflow-hidden">
                                <h3 class="text-2xl underline mb-3">{{ $category->name }}</h3>
                                @foreach ($category->fillings as $filling)
                                    <p class="text-left lg:text-lg">{{ $filling->title }}</p>
                                @endforeach
                            </div>
                            <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[300px] rounded-md object-cover"
                                src="{{ $category->fillings[0]->image }}" alt="">
                        </div>
                        <h4 class="text-3xl lg:text-2xl mt-3">{{ $category->name }}</h4>
                        <div class="flex justify-between mt-1 items-end">
                            <p class="text-red-300 text-3xl lg:text-2x+l">{{ $category->fillings[0]->unit_price }}
                                грн/кг</p>
                            <p class="text-xl">від {{ $category->fillings[0]->min_quantity }} шт.
                        </div>
                        <button @click="$store.cart.handleOpenModal(fillings[{{ $category->id }}])" class="button">
                            Обрати
                        </button>
                    </div>
                @endforeach
                <template x-if="additionFillings.length">
                    <template x-for="newFilling in additionFillings" :key="newFilling.id">
                        <div x-data="{ shown: false }" x-intersect.full="shown = true">
                            <div x-show="shown" x-transition class="px-4 mb-6">
                                <div class="relative">
                                    <div
                                        class="opacity-0 hover:opacity-100 transition-all absolute 
        top-0 left-0 w-full h-full z-10 bg-gray-500/80 rounded-md text-white p-3 overflow-hidden">
                                        <h3 class="text-2xl underline mb-3" x-text="newFilling.name"></h3>
                                        <template x-for="f in newFilling.fillings">
                                            <p class="text-left lg:text-lg" x-text="f.description"></p>
                                        </template>
                                    </div>
                                    <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[300px] rounded-md object-cover"
                                        :src="prepareFillingForCandybar(newFilling).image" alt="">
                                </div>
                                <h4 class="text-3xl lg:text-2xl mt-3" x-text="newFilling.title"></h4>
                                <div class="flex justify-between mt-1 items-end">
                                    <p class="text-red-300 text-3xl lg:text-2x+l"><span
                                            x-text="prepareFillingForCandybar(newFilling).unit_price"></span>
                                        грн/кг</p>
                                    <p class="text-xl">від <span
                                            x-text="chooseWeightQuantity(prepareFillingForCandybar(newFilling))"></span>
                                    </p>
                                </div>
                                <button @click="$store.cart.handleOpenModal(newFilling)" class="button">
                                    Обрати
                                </button>
                            </div>
                        </div>
                    </template>
                </template>


            </div>
            <div x-show="countHandler" class="flex items-center justify-center mb-14">
                <span class="block border w-full"></span>
                <div @click="addFillings"
                    class="min-w-[210px] px-6 py-2 shadow hover:bg-red-200 hover:text-white hover:border-red-200 cursor-pointer 
        transition-colors text-xl border-gray-500 border rounded-full">
                    Більше
                </div>
                <span class="block border w-full"></span>
            </div>
        </div>
    </section>
</x-app-layout>
