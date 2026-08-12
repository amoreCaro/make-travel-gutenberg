import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

function videoBanner() {
  const sections = document.querySelectorAll('.video-banner');
  if (!sections.length) return;

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  sections.forEach((section) => {
    const scrollBtn = section.querySelector('.video-banner__scroll');
    if (scrollBtn) {
      scrollBtn.addEventListener('click', () => {
        const next = section.nextElementSibling;
        const top = next
          ? next.getBoundingClientRect().top + window.scrollY
          : section.getBoundingClientRect().bottom + window.scrollY;

        window.scrollTo({
          top,
          behavior: prefersReducedMotion ? 'auto' : 'smooth',
        });
      });
    }

    const sliderEl = section.querySelector('.video-banner__slider');
    if (sliderEl && !sliderEl.swiper) {
      const raw = parseInt(sliderEl.getAttribute('data-slides-per-view') || '3', 10);
      const perView = Number.isFinite(raw) && raw >= 1 ? Math.min(raw, 8) : 3;

      // Keep a peek of the next slide on smaller screens when there is room.
      const mobile = Math.min(perView, 1.15);
      const sm = Math.min(perView, Math.max(1.4, perView * 0.55));
      const md = Math.min(perView, Math.max(1.8, perView * 0.75));

      new Swiper(sliderEl, {
        modules: [Navigation],
        slidesPerView: mobile,
        spaceBetween: 12,
        speed: prefersReducedMotion ? 0 : 550,
        watchOverflow: true,
        navigation: {
          nextEl: section.querySelector('.video-banner__slider-next'),
          prevEl: section.querySelector('.video-banner__slider-prev'),
          disabledClass: 'is-disabled',
        },
        breakpoints: {
          640: { slidesPerView: sm, spaceBetween: 14 },
          768: { slidesPerView: md, spaceBetween: 16 },
          1024: { slidesPerView: perView, spaceBetween: 18 },
        },
      });
    }

    const video = section.querySelector('.video-banner__video');
    if (!video) return;

    if (prefersReducedMotion) {
      video.remove();
      return;
    }

    const sourceUrl = video.dataset.src;
    if (!sourceUrl) return;

    let sourceLoaded = false;

    const loadSource = () => {
      if (sourceLoaded) return;
      sourceLoaded = true;

      const source = document.createElement('source');
      source.src = sourceUrl;
      source.type = 'video/mp4';
      video.appendChild(source);
      video.load();
    };

    const playVideo = () => {
      loadSource();
      const playPromise = video.play();
      if (playPromise?.then) {
        playPromise
          .then(() => {
            video.classList.add('opacity-100');
          })
          .catch(() => {
            // Autoplay blocked — keep video hidden.
          });
      }
    };

    const pauseVideo = () => {
      if (!video.paused) {
        video.pause();
      }
    };

    if (!('IntersectionObserver' in window)) {
      playVideo();
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            playVideo();
          } else {
            pauseVideo();
          }
        });
      },
      { threshold: 0.25 }
    );

    observer.observe(section);
  });
}

export { videoBanner };
