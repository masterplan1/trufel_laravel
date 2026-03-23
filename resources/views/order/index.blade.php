<x-app-layout>
    <section x-data="orderItem('{{ $date }}')" class="font-kurale text-center">
        <div class="pt-24 pb-16 px-4">
            <h1 class="font-amatic text-5xl mb-10 text-brand-text">Оформлення замовлення</h1>

            <div class="card max-w-md mx-auto p-8 text-left">
                <form action="{{ route('order.checkout') }}" method="POST" class="flex flex-col gap-5">
                    @csrf

                    <div>
                        <label class="block text-brand-muted text-sm mb-1.5">Ваше ім'я</label>
                        <input name="customer_name" required minlength="3"
                            class="w-full rounded-xl py-2.5 px-4 bg-brand-cream border border-brand-blush
                            focus:border-brand-rose focus:outline-none focus:ring-1 focus:ring-brand-rose
                            @error('customer_name') border-red-400 @enderror"
                            type="text" placeholder="Введіть ваше ім'я">
                        @error('customer_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-brand-muted text-sm mb-1.5">Номер телефону</label>
                        <input name="customer_phone" required minlength="3"
                            class="w-full rounded-xl py-2.5 px-4 bg-brand-cream border border-brand-blush
                            focus:border-brand-rose focus:outline-none focus:ring-1 focus:ring-brand-rose
                            @error('customer_phone') border-red-400 @enderror"
                            x-mask="{
                              numericOnly: true,
                              blocks: [3, 3, 2, 2],
                              delimiter: '-',
                              prefix: '0',
                              noImmediatePrefix: true
                            }"
                            placeholder="067-111-11-11" type="text">
                        @error('customer_phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-brand-muted text-sm mb-1.5">Дата видачі</label>
                        <input name="order_date" id="datePickerId" required
                            class="w-full rounded-xl py-2.5 px-4 bg-brand-cream border border-brand-blush
                            focus:border-brand-rose focus:outline-none focus:ring-1 focus:ring-brand-rose
                            @error('order_date') border-red-400 @enderror"
                            type="text" placeholder="Оберіть дату">
                        @error('order_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-1">
                        <p class="text-2xl text-brand-rose font-medium text-right">
                            Разом: {{ $totalPrice }} грн
                        </p>
                    </div>

                    <div class="text-sm text-brand-muted">
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" name="privacy_consent" required
                                class="mt-0.5 w-4 h-4 shrink-0 accent-brand-rose">
                            <span>Я погоджуюсь з
                                <a href="{{ route('privacy') }}" target="_blank"
                                    class="text-brand-rose hover:underline">політикою конфіденційності</a>
                                та надаю згоду на обробку моїх персональних даних
                            </span>
                        </label>
                    </div>

                    <button class="button !my-0 !mx-0 w-full" type="submit">Підтвердити замовлення</button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
