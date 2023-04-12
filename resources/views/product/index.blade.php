<x-app-layout>
    <section class="font-kurale text-center ">
        <div class="pt-28  relative">
            <h1 class="font-amatic  text-7xl mb-4">{{ $type->name }}</h1>
            <p class="hidden sm:block font-caveat text-3xl max-w-[60%] m-auto text-red-300">*тут ви можете переглянути
                можливі варіанти начинок
                для солодощів і вибрати собі щось за смаком.
            </p>
            <div class="hidden lg:block">
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute scale-50 top-16 left-1 w-32 h-36"></span>
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute scale-75 rotate-12 top-16 right-1 w-32 h-36"></span>
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute scale-50 -rotate-45 -bottom-12 left-1 w-32 h-36"></span>
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute scale-50 rotate-90 -bottom-12 right-1 w-32 h-36"></span>
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute -scale-50 rotate-90 bottom-4 left-24 w-32 h-36"></span>
                <span
                    class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute -scale-50 bottom-4 right-24 w-32 h-36"></span>
            </div>
        </div>
        <div x-data="productItem({{ json_encode(
            $products->mapWithKeys(
                fn($product, $key) => [
                    $product->id => [
                        'id' => $product->id,
                        'image' => $product->image,
                    ],
                ],
            ),
        ) }}, {{ $type }}, {{ $total_item_count }})" class="mt-10 sm:mt-20">
        @include('product.modal-zoom')
            @if (count($categories) > 1 && !$type->is_candybar)
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 mb-10 min-h-[460px] sm:min-h-[400px]" >
                @foreach ($products as $product)
                    <div x-show="!categoryWasSelected" class="px-4 mb-6 relative h-[80vw] sm:h-[36vw] lg:h-[300px]">
                        <div
                            class="absolute bottom-4 bg-gray-200/20 right-8 text-white cursor-pointer p-2 rounded-full backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" @click="zoomImage($el)"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <img class="w-full h-full rounded-md object-cover"
                            src="{{ $product->image }}" alt="">
                    </div>
                @endforeach
                <template x-if="additionProducts.length">
                    <template x-for="newProduct in additionProducts" :key="newProduct.id">
                        <div x-data="{ shown: false }" x-intersect.full="shown = true">
                            <div x-show="shown" x-transition class="px-4 mb-6 relative">
                                <div
                                    class="absolute bottom-4 bg-gray-200/20 right-8 text-white cursor-pointer p-2 rounded-full backdrop-blur-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" @click="zoomImage($el)"
                                        stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[300px] rounded-md object-cover"
                                    :src="newProduct.image" alt="">
                            </div>
                        </div>
                    </template>
                </template>
            </div>
            <div x-show="countHandler" class="flex items-center justify-center mb-14">
                <span class="block border w-full"></span>
                <div @click="addProducts"
                    class="min-w-[210px] px-6 py-2 shadow hover:bg-red-200 hover:text-white hover:border-red-200 cursor-pointer 
      transition-colors text-xl border-gray-500 border rounded-full">
                    Більше
                </div>
                <span class="block border w-full"></span>
            </div>
        </div>
    </section>
</x-app-layout>
