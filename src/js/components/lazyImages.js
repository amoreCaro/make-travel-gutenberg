// lazyImages.js
export function lazyLoadImages() {
  const lazyImages = document.querySelectorAll('[data-src]');

  lazyImages.forEach((img) => {
    // Додаємо клас для початкового blur
    img.classList.add('lazy-img');

    // Коли картинка завантажиться, видаляємо blur через клас is-loaded
    img.onload = () => {
      img.classList.add('is-loaded');
    };

    // Встановлюємо справжній src з data-src
    const src = img.getAttribute('data-src');
    img.setAttribute('src', src);
  });
}