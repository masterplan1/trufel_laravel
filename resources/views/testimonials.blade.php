<x-app-layout>
    <section class="font-kurale text-center">
        <x-title>
            <x-slot:title>
                Відгуки
                </x-slot>
                Думка наших незалежних експертів дуже важлива для нас. Маєте, що сказати про нас, будь-ласка, залиште
                нам Ваш відгук.
        </x-title>
        <div class="pt-12" x-data="testimonialItem({{ count($comments) }})">
            <div @click="isFormOpened = !isFormOpened"
                class="mx-auto text-red-300 hover:text-red-400 w-fit transition-colors">
                <svg x-show="!isFormOpened" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="cursor-pointer w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg x-show="isFormOpened" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="cursor-pointer w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div x-cloak
                class="my-6 max-w-2xl text-xl mx-auto px-2 flex justify-center items-center transition-all duration-500
          border-b border-t border-gray-200 overflow-hidden"
                :class="isFormOpened ? 'h-[500px] sm:h-[420px]' : 'h-0'">
                <form @submit.prevent="formSubmit" action="" class="flex flex-col gap-4 py-6">
                    <h3 class="text-2xl mb-6">Додати відгук</h3>
                    <div class="flex justify-between items-center flex-col sm:flex-row">
                        <label for="" class="mb-2 sm:mb-0">Ваше ім'я</label>
                        <input name="author_name" required minlength="3" x-model="formData.author_name"
                            class="border-gray-400 p-2 ml-6 border focus:border-purple-500 focus:outline-none focus:ring-purple-500 
              rounded-md"
                            placeholder="Ваше ім'я" type="text">
                    </div>
                    <div name="estimation" class="flex justify-between flex-col sm:flex-row">
                        <label for="" class="mb-2 sm:mb-0">Оцінка</label>
                        <div class="flex ml-6">
                            <template x-for="item in 5" :key="item">
                                <svg @mouseenter="starMouseEnter(item)" @mouseleave="starMouseLeave(item)"
                                    @click="chooseEstimation(item)" xmlns="http://www.w3.org/2000/svg"
                                    x-bind:fill="mouseOver[item] ? 'currentColor' : 'none'" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="text-red-300 w-6 h-6 transition-colors cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </template>
                        </div>
                    </div>
                    <div class="flex justify-between items-center flex-col sm:flex-row">
                        <label for="" class="mb-2 sm:mb-0">Відгук</label>
                        <textarea name="description" required minlength="3" maxlength="140" x-model="formData.description"
                            placeholder="Ваш відгук, до 140 символів"
                            class="border-gray-400 p-2 min-h-[120px] min-w-[254px] border focus:border-purple-500 focus:outline-none focus:ring-purple-500 
              rounded-md"></textarea>
                    </div>
                    <button class="button" type="submit">Додати</button>
                </form>
            </div>
            <div class="flex justify-center sm:gap-8 items-center my-12">
                <div class="text-red-300 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="decreaseAnimationStep" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 sm:w-12 sm:h-12 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </div>
                <div class="overflow-hidden w-[288px] lg:w-[864px]">
                    <div class="text-md mt-8 mb-14 flex w-[9999px] transition-all"
                        :style="{ 'transform': `translateX(-${animationItemWidth*animationStep}px)` }">
                        <template x-if=newComments.length> 0>
                            <template x-for="newComment in newComments">
                                <div class="w-[238px] mr-[25px] ml-[25px]">
                                    <h3 class="text-2xl mb-3" x-text="newComment.author_name"></h3>
                                    <div class="flex justify-center mb-3" x-data="{
                                        estimation: newComment.estimation ?? 5,
                                    }">
                                        <template x-for="item in 5" :key="item">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                :fill="estimation >= item ? 'currentColor' : 'none'" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="text-red-300 w-6 h-6 transition-colors cursor-pointer">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <hr class="mb-3">
                                    <p class="text-left" x-text="newComment.description"></p>
                                </div>
                            </template>
                        </template>
                        @foreach ($comments as $comment)
                            <div class="w-[238px] mr-[25px] ml-[25px]">
                                <h3 class="text-2xl mb-3">{{ $comment->author_name }}</h3>
                                <div class="flex justify-center mb-3" x-data="{
                                    estimation: {{ $comment->estimation ?? 5 }},
                                }">
                                    <template x-for="item in 5" :key="item">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            :fill="estimation >= item ? 'currentColor' : 'none'" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="text-red-300 w-6 h-6 transition-colors cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                    </template>
                                </div>
                                <hr class="mb-3">
                                <p class="text-left">
                                    {{ $comment->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-red-300 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="increaseAnimationStep" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 sm:w-12 sm:h-12 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
