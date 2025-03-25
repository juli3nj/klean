<footer class="mt-12 relative">
  <img src="{{asset('images/sep-footer.png')}}" class="max-h-[95px] w-full absolute top-[-1px] left-0 z-0" alt="">
  <img src="{{asset('images/bg-footer.png')}}" class="w-full absolute bottom-[-1px] top-0 left-0 -z-10 max-h-auto xl:max-h-[300px]" alt="">
    <div class="relative z-20 flex flex-col items-center justify-center py-12">
      <div class="-mt-16">
        <img src="{{asset('images/logo.svg')}}" alt="klean peinture" class="w-[165px]">
      </div>
      <ul class="flex flex-col items-center justify-center mt-6 lg:flex-row gap-x-8 font-medium">
        <li class="">
          <a href="{{get_permalink('mentions-legales')}}" class="hover:text-secondary-800">Mentions légales</a>
        </li>
        <li class="">
          <a href="{{get_permalink('politique-de-confidentialite')}}" class="hover:text-secondary-800 mt-4 lg:mt-0">Politique de confidentialité</a>
        </li>
        <li class="flex items-center">
          Suivez notre actualité sur
          <x-socials linkClass="pl-4 text-primary-1000 hover-[&_*]:text-secondary-800"
              containerClass="flex flex-row justify-center items-center"
              :useBlade="true"
              :icons="['instagram', 'facebook','linkedin', 'tiktok', 'youtube']" />
        </li>
      </ul>
      <div class="flex flex-col lg:flex-row mt-8 text-sm">
        <span class="">{{the_date('Y')}} &copy; droits réservés Klean Peinture</span>
        <span class="hidden mx-2 lg:block"> - </span>
        <span class="">Site réalisé par <a class="hover:text-secondary-800" href="https://https://www.manaraw.fr/" target="_blank">Manaraw Studio</a></span>
      </div>
    </div>
</footer>