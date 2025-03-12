<div class="absolute right-0 bottom-20"
    @click.outside="open = false"
    x-data="{ open: false }">
<div
    x-on:click="open = !open"
    :class="{ 'right-[280px]': open, 'right-0': !open }"
    class="fixed right-0 bottom-20 cursor-pointer z-50 transition-all">
    <div class="mt-32"></div>
    <div class="w-16 h-16 border-[3px] border-secondary-600 font-medium flex items-center justify-center bg-primary-1000 shadow-xl" id="phone">
      <canvas id="lottiePhone" class="w-full h-full "></canvas>
    </div>
</div>
<div
    :class="{ 'right-0': open, '-right-[280px]': !open }"
    class="fixed right-0 bottom-20 h-[150px] w-[280px] pl-8 flex justify-center flex-col bg-primary-1000 z-50 transition-all shadow-xl" id="phoneModal">
  <span>Nous contacter<br>par téléphone</span>
  <a href="tel:{{ getInternationalPhone() }}" class="block text-xl font-medium mt-4 text-secondary-600">{{getPhone()}}</a>
</div>
</div>
