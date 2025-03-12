import alpine from 'alpinejs';
import Swiper from 'swiper';
import 'lightbox2';
import SimpleParallax from "simple-parallax-js/vanilla";
import { DotLottie } from '@lottiefiles/dotlottie-web';
import AOS from 'aos';

import 'aos/dist/aos.css';
import 'swiper/css';
import 'lightbox2/dist/css/lightbox.css';

Object.assign(window, {Alpine: alpine}).Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
  AOS.init();


  const swiper = new Swiper('.swiperGallery', {
    loop: false,
    slidesPerView: 1.2,
    spaceBetween: 10,
    breakpoints: {
      420: {
        slidesPerView: 1.8,
        spaceBetween: 25,
      },
      640: {
        slidesPerView: 2.8,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 3.8,
        spaceBetween: 50,
      },
      1400: {
        slidesPerView: 4.8,
        spaceBetween: 60,
      },
    },
  });

  const dotLottie = new DotLottie({
    autoplay: true,
    loop: true,
    canvas: document.querySelector('#lottiePhone'),
    src: 'dist/images/lotties/proicons_phone.json',
  });


  const image = document.getElementsByClassName('parallaxTriangle');
  new SimpleParallax(image, {
  });

  const imageLeft = document.getElementsByClassName('parallaxTriangleLeft');
  new SimpleParallax(imageLeft, {
  });

});

import.meta.webpackHot?.accept(console.error);
