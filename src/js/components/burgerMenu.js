export function burgerMenu() {
  const burgerMenu = document.getElementById('burgerMenu');
  const openBtn = document.getElementById('openBurgerBtn');
  const closeBtn = document.getElementById('closeBurger');

  if (!burgerMenu || !openBtn || !closeBtn) return;

  /** Відкриття меню */
  function openMenu() {
    burgerMenu.classList.add('showSlide');
    document.body.classList.add('overflow-y-hidden');
  }

  /** Закриття меню */
  function closeMenu() {
    burgerMenu.classList.remove('showSlide');
    document.body.classList.remove('overflow-y-hidden');
  }

  /** Клік по кнопці відкриття */
  openBtn.addEventListener('click', (e) => {
    e.preventDefault();
    openMenu();
  });

  /** Клік по кнопці закриття */
  closeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeMenu();
  });

  /** Закриття при кліку поза меню */
  burgerMenu.addEventListener('click', (e) => {
    if (e.target === burgerMenu) closeMenu();
  });
}
