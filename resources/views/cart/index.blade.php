<x-app-layout>
    <section class="font-kurale text-center">
        <div class="pt-28 px-4" x-data="{
            cartItems: {{ json_encode(
                $fillings->map(
                    fn($filling) => [
                        'id' => $filling->id,
                        'min_weight' => $filling->min_weight,
                        'min_quantity' => $filling->min_quantity,
                        'title' => $filling->title,
                        'image' => $filling->image,
                        'category' => $filling->category,
                        'type' => $filling->type,
                        'candybar_select_items' => $filling->type->is_candybar ? ($filling->category?->fillings ?? []) : null,
                        'price' => $cartItems[$filling->id]['price'],
                        'weight' => $cartItems[$filling->id]['weight'] ?? null,
                        'quantity' => $cartItems[$filling->id]['quantity'] ?? 1,
                        'updateUrl' => route('cart.add', $filling),
                        'changeUrl' => route('cart.change-filling', $filling),
                        'removeUrl' => route('cart.remove', $filling),
                        'hasWeight' => $filling->type->weight_quantity === 'weight',
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
            <h1 class="font-amatic text-7xl mb-10 text-brand-text">Кошик</h1>

            <template x-if="!cartItems.length">
                <div class="py-16 flex flex-col items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="w-20 h-20 text-brand-blush">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    <p class="font-caveat text-3xl text-brand-muted">кошик порожній</p>
                    <a href="{{ route('filling', App\Models\Type::first()) }}"
                        class="btn-outline inline-block mt-2">До каталогу</a>
                </div>
            </template>

            <template x-if="cartItems.length">
                <div>
                    <template x-for="cartItem in cartItems" :key="cartItem.id">
                        <div x-data="handleCart(cartItem)"
                            class="card max-w-2xl mx-auto mb-6 text-left overflow-visible">
                            <div class="p-5 relative flex flex-col items-center justify-between sm:flex-row gap-5 text-lg">

                                {{-- Remove button --}}
                                <button @click="removeItemFromCart"
                                    class="absolute top-3 right-3 p-1.5 rounded-full bg-brand-cream
                                    hover:bg-brand-blush transition-colors duration-200 text-brand-muted hover:text-brand-rose-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <img class="w-[180px] h-[180px] rounded-xl object-cover flex-shrink-0"
                                    :src="filling.image" alt="">

                                <div class="flex-1 w-full">
                                    <h3 class="font-caveat text-3xl text-brand-rose-dark mb-4" x-text="getHeaderTitle"></h3>

                                    <div class="flex flex-col gap-3">

                                        {{-- Filling name --}}
                                        <p class="bg-brand-blush px-3 py-1.5 rounded-lg text-brand-text"
                                            x-text="getFillingTitle"></p>

                                        {{-- Weight / Quantity --}}
                                        <div class="flex items-center gap-3">
                                            <span class="text-brand-muted text-sm w-20"
                                                x-text="filling.type.weight_quantity === 'weight' ? 'Вага' : 'Кількість'"></span>
                                            <template x-if="filling.type.weight_quantity === 'weight'">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center bg-brand-blush rounded-lg overflow-hidden">
                                                        <button class="px-3 py-1.5 text-xl hover:bg-brand-rose hover:text-white transition-colors"
                                                            @click="handleWeightDecrease">−</button>
                                                        <span class="px-4 py-1.5 min-w-[50px] text-center" x-text="filling.weight"></span>
                                                        <button class="px-3 py-1.5 text-xl hover:bg-brand-rose hover:text-white transition-colors"
                                                            @click="handleWeightIncrease">+</button>
                                                    </div>
                                                    <span class="text-brand-muted text-sm">кг</span>
                                                </div>
                                            </template>
                                            <template x-if="filling.type.weight_quantity === 'quantity'">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center bg-brand-blush rounded-lg overflow-hidden">
                                                        <button class="px-3 py-1.5 text-xl hover:bg-brand-rose hover:text-white transition-colors"
                                                            @click="handleQuantityDecrease">−</button>
                                                        <span class="px-4 py-1.5 min-w-[50px] text-center" x-text="filling.quantity"></span>
                                                        <button class="px-3 py-1.5 text-xl hover:bg-brand-rose hover:text-white transition-colors"
                                                            @click="handleQuantityIncrease">+</button>
                                                    </div>
                                                    <span class="text-brand-muted text-sm">шт</span>
                                                </div>
                                            </template>
                                        </div>

                                        <p class="text-2xl text-brand-rose font-medium">
                                            <span x-text="filling.price"></span> грн
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="hasCake">
                <p class="text-brand-muted font-kurale text-base max-w-lg m-auto mt-4 mb-2">
                    Декор тортика (топери, фігурки та інше) у ціну не входить.
                </p>
            </template>

            <div x-show="cartItems.length"
                class="flex justify-between items-center max-w-2xl mx-auto mt-10 mb-16 gap-4 flex-col-reverse sm:flex-row">
                <a href="{{ url()->previous() }}"
                    class="text-brand-muted hover:text-brand-rose transition-colors duration-200">
                    ← Продовжити покупки
                </a>
                <div class="text-2xl font-medium text-brand-rose">
                    Разом: <span x-text="cartTotal"></span> грн
                </div>
                <a href="{{ route('order.index') }}" class="button !my-0 !mx-0 px-8 py-2.5">
                    Оформити замовлення
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
