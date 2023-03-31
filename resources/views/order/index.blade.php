<x-app-layout>
    <section x-data="orderItem('{{ $date }}')" class="font-kurale text-center">
        <div class="pt-28  relative">
            <h1 class="font-amatic  text-5xl mb-8">Оформлення замовлення</h1>
        </div>
        <div class="text-lg max-w-sm">
            <form action="{{ route('order.checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="flex">
                        <label class="mr-4" for="">Ім'я</label>
                        <input name="customer_name" required minlength="3"
                            class="@error('customer_name') border border-red-500 @enderror flex-1 rounded py-1 bg-red-100 px-2 !outline-none"
                            type="text">
                    </div>
                    @error('customer_name')
                        <div class="text-red-400 w-full">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-4 ">
                    <div class="flex">
                        <label class="mr-4" for="">Дата видачі</label>
                        <input name="order_date" id="datePickerId" required
                            class="@error('order_date') border border-red-500 @enderror flex-1 rounded py-1 bg-red-100 px-2 !outline-none" type="text">
                    </div>
                    @error('order_date')
                        <div class="text-red-400 w-full">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="flex">
                        <label class="mr-4" for="">Номер телефону</label>
                        <input name="customer_phone" required minlength="3"
                            class="@error('customer_phone') border border-red-500 @enderror flex-1 rounded py-1 bg-red-100 px-2 !outline-none"
                            x-mask="{
                              numericOnly: true,
                              blocks: [3, 3, 2, 2],
                              delimiter: '-',
                              prefix: '0',
                              noImmediatePrefix: true
                            }"
                            placeholder="067-111-11-11" type="text">
                    </div>
                    @error('customer_phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-3xl text-red-600 text-right">
                    Ціна {{ $totalPrice }} грн
                </div>
                <button class="button" type="submit">Підтвердити</button>
            </form>
        </div>
    </section>
</x-app-layout>
