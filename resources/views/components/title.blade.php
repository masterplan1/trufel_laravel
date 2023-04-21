<div>
    <div class="pt-28  relative">
        <h1 class="font-amatic  text-7xl mb-4">{{ $title }}</h1>
        <p class="hidden sm:block font-caveat text-3xl max-w-[60%] m-auto text-red-300">{{ $slot }}</p>
        <div class="hidden lg:block">
            <span
                style="transform: scale(.{{ random_int(3, 9) }});"
                class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute top-16 -left-10 w-32 h-36"></span>
            <span
                style="transform: scale(.{{ random_int(3, 9) }});"
                class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute rotate-12 top-16 -right-16 w-32 h-36"></span>
            <span
                class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute scale-50 -rotate-45 -bottom-12 -left-16 w-32 h-36"></span>
            <span
                {{-- style="transform: rotate({{ random_int(0, 360) }}deg);" --}}
                class="bg-[url('/public/img/svg/wellcome-cake-icon.svg')] absolute -bottom-12 scale-50 -right-10 w-32 h-36"></span>
            <span
                class="bg-[url('/public/img/svg/cupcake-icon.svg')] bg-no-repeat absolute -scale-50 rotate-90 bottom-4 left-8 w-32 h-36"></span>
            <span
                class="bg-[url('/public/img/svg/cupcake-icon.svg')] bg-no-repeat absolute -scale-50 bottom-4 right-7 w-32 h-36"></span>
        </div>
    </div>
</div>
