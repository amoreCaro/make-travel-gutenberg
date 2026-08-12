import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

export function slider() {
  const sliders = document.querySelectorAll('.post-card--slider .slider');

  sliders.forEach((sliderEl) => {
    if (sliderEl.swiper) return;

    const parent = sliderEl.closest('.post-card--slider');
    if (!parent) return;

    const nextBtn = parent.querySelector('.slider__next');
    const prevBtn = parent.querySelector('.slider__prev');
    const pagination = parent.querySelector('.slider__pagination');
    const slideCount = sliderEl.querySelectorAll('.swiper-slide').length;
    const canLoop = slideCount > 1;

    [prevBtn, nextBtn].forEach((btn) => {
      if (!btn) return;
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
      });
    });

    new Swiper(sliderEl, {
      modules: [Navigation, Pagination],
      loop: canLoop,
      speed: 500,
      nested: true,
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
        disabledClass: 'is-disabled',
      },
      pagination: {
        el: pagination,
        clickable: true,
      },
      watchOverflow: true,
    });
  });
}
