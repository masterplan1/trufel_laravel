<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                Контакти
                </x-slot>
                
        </x-title>
        <div class="p-12">
            <div class="text-2xl">
                <div>
                    <p class="text-left mb-16 text-xl"> 
                        Самовивіз замовлень можна
                        здійснити за адресою: м. Обухів, вул. Молодіжна 2, (поблизу магазину "Околиця");
                    </p>
                </div>
                <div class="flex items-center justify-center gap-3 mb-6 sm:flex-row flex-col">
                    <div class="flex gap-3">
                        <img class="w-10 h-10 bg-red-300 rounded-full p-1" src="/img/svg/viber-icon.svg" alt="">
                        <img class="w-10 h-10 bg-red-300 rounded-full p-1" src="/img/svg/telegram-icon.svg" alt="">
                        <div class="w-10 h-10 bg-red-300 rounded-full p-1 text-white flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                    </div>
                    <a href="tel:0934978646">(093)497-86-46</a>
                </div>
                <a target="_blank" href="https://www.instagram.com/tru._.fel/"
                    class="flex items-center justify-center gap-3">
                    <img class="w-10 h-10" src="/img/svg/instagram-icon.svg" alt="">
                    tru._.fel
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
