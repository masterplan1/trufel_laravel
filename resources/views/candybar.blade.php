<x-app-layout>
<section class="font-kurale text-center">
  <div class="pt-28  relative">
    <h1 class="font-amatic  text-7xl mb-4">{{ $type->name }}</h1>
    <p class="hidden sm:block font-caveat text-3xl max-w-[60%] m-auto text-red-300">*тут ви можете переглянути можливі варіанти начинок
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
  <div class="mt-10 sm:mt-20">
   
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1 mb-10">

      @foreach ($categories as $category)
        @if (count($category->fillings) > 0)
          <div x-data="{ 
            get filling(){
              return {{ json_encode([
                'id' => $category->id,
                'image' => $category->fillings[0]->image,
                'title' => $category->name,
                'unit_price' => $category->fillings[0]->unit_price,
                'min_quantity' => $category->fillings[0]->min_quantity ?? null,
                'fillings' => $category->fillings,
                'type' => $type,
                ]) }} 
            } 
          }" class="px-4 mb-6">
            <div class="relative">
              <div class="opacity-0 hover:opacity-100 transition-all absolute 
                top-0 left-0 w-full h-full z-10 bg-gray-500/80 rounded-md text-white p-3 overflow-hidden">
                <h3 class="text-2xl underline mb-3">{{ $category->name }}</h3>
                @foreach ($category->fillings as $filling)
                  <p class="text-left lg:text-lg">{{ $filling->title }}</p>
                @endforeach
              </div>
              <img class="w-full h-[80vw] sm:h-[36vw] lg:h-[300px] rounded-md object-cover" src="{{ $category->fillings[0]->image }}" alt="">
            </div>
            <h4 class="text-3xl lg:text-2xl mt-3">{{ $category->name }}</h4>
            <div class="flex justify-between mt-1 items-end">
              <p class="text-red-300 text-3xl lg:text-2x+l">{{ $category->fillings[0]->unit_price }} грн/кг</p>
              <p class="text-xl">від {{ $category->fillings[0]->min_quantity }} шт.</div>
            <button @click="$store.cart.handleOpenModal(filling)" class="button">
                Обрати
            </button>
          </div>
        @endif
      @endforeach
      
    </div>
    <div class="flex items-center justify-center mb-14">
      <span class="block border w-full"></span>
      <div class="min-w-[210px] px-6 py-2 shadow hover:bg-red-200 hover:text-white hover:border-red-200 cursor-pointer 
        transition-colors text-xl border-gray-500 border rounded-full">
        Більше
      </div>
      <span class="block border w-full"></span>
    </div>
  </div>
</section>
</x-app-layout>