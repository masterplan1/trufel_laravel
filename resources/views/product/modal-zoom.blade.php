<div 
  id="zoomModal" 
  class="hidden fixed z-50 left-0 pt-16 top-0 w-full h-full overflow-auto bg-gray-900/70"
  @click="closeZoomModal"
>
  <img src="" alt="" id="zoomImg" :class="closeModalClicked ? 'animate-zoom-out' : 'animate-zoom-in' " class="animate-zoom-in m-auto block max-w-[95%] max-h-[95%]">
</div>