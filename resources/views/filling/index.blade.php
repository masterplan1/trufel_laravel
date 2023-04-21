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
                        'type_is_candybar' => $type->is_candybar,
                        // 'type' => $type,
                    ],
                ],
            ),
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-10 sm:mt-20">
            @if (count($categories) > 1)
                <div class="flex justify-around gap-4 flex-wrap mb-8 text-center items-center">
                    <div @click="selectCategory(0)"
                        class="min-w-[142px] sm:min-w-[210px] px-2 sm:px-6 sm:py-2 shadow hover:bg-red-200 hover:text-white hover:border-red-200 cursor-pointer 
        transition-colors sm:text-xl border-gray-500 border rounded-full"
                        :class="{ 'bg-red-200 text-white border-red-200': activeClassCategory === null }">
                        Весь асортимент
                    </div>

                    @foreach ($categories as $key => $category)
                        <div @click="selectCategory({{ $category->id }}, {{ $key }})"
                            class="min-w-[142px] sm:min-w-[210px] px-2 sm:px-6 sm:py-2 shadow hover:bg-red-200 hover:text-white hover:border-red-200 cursor-pointer 
        transition-colors sm:text-xl border-gray-500 border rounded-full"
                            :class="{ 'bg-red-200 text-white border-red-200': activeClassCategory === {{ $key }} }">
                            {{ $category->name }}
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 mb-10 min-h-[460px] sm:min-h-[400px]">
                @foreach ($fillings as $filling)
                    <div x-show="!categoryWasSelected" class="px-4 mb-6">
                        <div class="relative">
                            <div
                                class="opacity-0 hover:opacity-100 transition-all absolute 
            top-0 left-0 w-full h-full z-10 bg-gray-500/90 rounded-md text-white p-3 overflow-hidden">
                                <h3 class="text-2xl underline mb-3">{{ $filling->title }}</h3>
                                <p class="text-left lg:text-lg">{{ $filling->description }}</p>
                            </div>
                            <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[280px] rounded-md object-cover"
                                src="{{ $filling->image }}" alt="">
                        </div>
                        <h4 class="text-3xl lg:text-2xl mt-3">{{ $filling->title }}</h4>
                        <div class="flex justify-between mt-1 items-end">
                            <p class="text-red-300 text-3xl lg:text-2x+l">{{ $filling->unit_price }} грн/кг</p>
                            <p class="text-xl">від <?php
                            if ($type->weight_quantity === 'weight') {
                                echo $filling->min_weight . ' кг.';
                            } else {
                                echo $filling->min_quantity . ' шт.';
                            }
                            ?></p>
                        </div>
                        <button @click="$store.cart.handleOpenModal(fillings[{{ $filling->id }}])" class="button">
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
        top-0 left-0 w-full h-full z-10 bg-gray-500/90 rounded-md text-white p-3 overflow-hidden">
                                        <h3 class="text-2xl underline mb-3" x-text="newFilling.title"></h3>
                                        <p class="text-left lg:text-lg" x-text="newFilling.description"></p>
                                    </div>
                                    <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[280px] rounded-md object-cover"
                                        :src="newFilling.image" alt="">
                                </div>
                                <h4 class="text-3xl lg:text-2xl mt-3" x-text="newFilling.title"></h4>
                                <div class="flex justify-between mt-1 items-end">
                                    <p class="text-red-300 text-3xl lg:text-2x+l"><span
                                            x-text="newFilling.unit_price"></span>
                                        грн/кг</p>
                                    <p class="text-xl">від <span x-text="chooseWeightQuantity(newFilling)"></span>
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
