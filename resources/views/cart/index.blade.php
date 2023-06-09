<x-app-layout>
    <section class="font-kurale text-center">
        <div class="pt-28" x-data="{
            cartItems: {{ json_encode(
                $fillings->map(
                    fn($filling) => [
                        'id' => $filling->id,
                        'min_weight' => $filling->min_weight,
                        'min_quantity' => $filling->min_quantity,
                        'title' => $filling->title,
                        'image' => $filling->image,
                        'category' => $filling->category,
                        'candybar_select_items' => $filling->type()->is_candybar ? $filling->category->fillings : null,
                        'price' => $cartItems[$filling->id]['price'],
                        'weight' => $cartItems[$filling->id]['weight'] ?? null,
                        'quantity' => $cartItems[$filling->id]['quantity'] ?? 1,
                        'updateUrl' => route('cart.add', $filling),
                        'changeUrl' => route('cart.change-filling', $filling),
                        'removeUrl' => route('cart.remove', $filling),
                        'hasWeight' => $filling->type()->weight_quantity === 'weight',
                    ],
                ),
            ) }},
            get cartTotal() {
                return this.cartItems.reduce((carry, item) => {
                    let itemSum = 0
                    if (item.hasWeight) {
                        itemSum = item.weight * item.price
                    } else {
                        itemSum = item.quantity * item.price
                    }
                    return carry + itemSum
                }, 0)
            },
            get hasCake() {
                return this.cartItems.find((item) => item.hasWeight)
            }
        }">
            <h1 class="font-amatic  text-7xl mb-16">кошик</h1>
            <template x-if="!cartItems.length">
                <div class="px-4 mb-6 relative flex flex-col items-center sm:flex-row sm:text-2xl">
                    <p class="font-caveat text-center w-full text-4xl">кошик порожній</p>
                </div>
            </template>
            <template x-if="cartItems.length">
                <template x-for="cartItem in cartItems" :key="cartItem.id">
                    <div x-data="handleCart(cartItem)" class="lg:w-[750px] mb-10">
                        <div class="px-4 mb-6 relative flex flex-col items-center justify-between sm:flex-row text-2xl">
                            <div @click="removeItemFromCart"
                                class="absolute sm:top-0 -top-10 right-1 p-1 rounded cursor-pointer bg-amber-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <img class="w-[240px] h-[240px] rounded-md object-cover" :src="filling.image"
                                alt="">
                            <div class="sm:ml-16 p-4">
                                <h3 class="font-caveat text-left text-4xl text-red-800 mb-3" x-text="getHeaderTitle">
                                </h3>
                                <div class="flex gap-1 sm:gap-6">
                                    <div class="hidden lg:block">
                                        <p class="mb-3 p-1">Начинка</p>
                                        <p x-show="filling.category.type.weight_quantity === 'weight'">Вага</p>
                                        <p x-show="filling.category.type.weight_quantity === 'quantity'">Кількість</p>
                                    </div>
                                    <div>

                                        <template x-if="!filling.category.type.is_candybar">
                                            <p class="bg-red-100 p-1 rounded mb-3 w-[240px] whitespace-nowrap overflow-hidden" x-text="getFillingTitle"></p>
                                        </template>
                                        <template x-if="filling.category.type.is_candybar">
                                            <select @change="handleFillingSelecet" x-model="candybarFillingId"
                                                class="bg-red-100 p-1 rounded mb-3 w-[240px] whitespace-nowrap overflow-hidden">
                                                <template x-for="item in filling.candybar_select_items"
                                                    :key="item.id">
                                                    <option :value="item.id" x-text="item.title"
                                                        :selected="item.id === filling.id"></option>
                                                </template>
                                            </select>
                                        </template>
                                        <div class="flex mb-3">
                                            <span class="block mr-3 lg:hidden"
                                                x-show="filling.category.type.weight_quantity === 'weight'">Вага</span>
                                            <span class="block mr-3 lg:hidden"
                                                x-show="filling.category.type.weight_quantity === 'quantity'">Кількість</span>
                                            <template x-if="filling.category.type.weight_quantity === 'weight'">
                                                <div class="flex">
                                                    <div class="px-3 bg-red-100 flex gap-4 mr-4 rounded">
                                                        <p class="cursor-pointer" @click="handleWeightIncrease">+</p>
                                                        <p class="min-w-[40px] text-center" x-text="filling.weight"></p>
                                                        <p class="cursor-pointer" @click="handleWeightDecrease">-</p>
                                                    </div>
                                                    <p>кг.</p>
                                                </div>
                                            </template>
                                            <template x-if="filling.category.type.weight_quantity === 'quantity'">
                                                <div class="flex">
                                                    <div class="px-3 bg-red-100 flex gap-4 mr-4 rounded">
                                                        <p class="cursor-pointer" @click="handleQuantityIncrease">+</p>
                                                        <p class="min-w-[40px] text-center" x-text="filling.quantity"></p>
                                                        <p class="cursor-pointer" @click="handleQuantityDecrease">-</p>
                                                    </div>
                                                    <p>шт.</p>
                                                </div>
                                            </template>

                                        </div>
                                        <div class="text-left text-3xl text-red-600"><span
                                                x-text="filling.price"></span> грн</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <hr class="mb-5">
            <template x-if="hasCake">
                <p class="hidden sm:block font-kurale text-2xl max-w-[80%] m-auto text-red-600">
                    Декор тортика (топери, фігурки та інше), у ціну не входить.
                </p>
            </template>
            <div x-show="cartItems.length"
                class="flex justify-between items-center px-4 text-xl mt-14 mb-16 gap-4 flex-col-reverse sm:flex-row">
                <a href="{{ url()->previous() }}">Продовжити покупки</a>
                <div
                    class="px-6 py-1 shadow bg-red-200 hover:bg-red-100 hover:border-red-200 cursor-pointer 
            transition-colors text-2xl border-gray-500 rounded-full">
                    <a href="{{ route('order.index') }}">Оформити</a>
                </div>
                <div class="text-3xl text-red-600">
                    Ціна <span x-text="cartTotal"></span> грн
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
