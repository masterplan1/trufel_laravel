<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                {{ $type->name }}
            </x-slot>
            *маленькі солодощі для кожного гостя — оберіть свій вид кендібару
        </x-title>

        <div class="mt-8 sm:mt-16 px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto mb-16">
                @foreach ($candybarTypes as $candybarType)
                    @php $previewImage = $candybarType->previewImage(); @endphp
                    <a href="{{ route('filling', $candybarType) }}"
                        class="card flex flex-col group">
                        <div class="relative overflow-hidden rounded-t-2xl">
                            @if ($previewImage)
                                <img class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] object-cover
                                    group-hover:scale-105 transition-transform duration-500"
                                    src="{{ $previewImage }}" alt="{{ $candybarType->name }}" loading="lazy">
                            @else
                                <div class="w-full h-[60vw] sm:h-[32vw] lg:h-[240px] bg-brand-blush
                                    flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1" stroke="currentColor"
                                        class="w-16 h-16 text-brand-rose/40">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Overlay on hover -->
                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 absolute
                                inset-0 bg-brand-text/50 flex items-center justify-center rounded-t-2xl">
                                <span class="text-white text-lg font-medium border border-white/60 px-5 py-2 rounded-full">
                                    Переглянути
                                </span>
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="text-xl mb-1">{{ $candybarType->name }}</h3>
                            @php
                                $firstFilling = $candybarType->categories()->with('fillings')->first()?->fillings()->first();
                            @endphp
                            @if ($firstFilling)
                                <p class="text-brand-rose text-lg font-medium mt-auto pt-2">
                                    від {{ $firstFilling->unit_price }} грн/шт
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
