export function burgerMenu() {
  const burgerMenu = document.getElementById('burgerMenu');
  const openBtn = document.getElementById('openBurgerBtn'); 
  const closeBtn = document.getElementById('closeBurger');

  openBtn.addEventListener('click', () => {
    console.log("clicked open button");
    burgerMenu.classList.remove('hidden');
    burgerMenu.classList.add('flex');
    document.body.classList.add("overflow-y-hidden");
  });

  closeBtn.addEventListener('click', () => {
    burgerMenu.classList.add('hidden');
    burgerMenu.classList.remove('flex');
    document.body.classList.remove("overflow-y-hidden");
  });

  // Закриття при натисканні поза контейнером
  burgerMenu.addEventListener('click', (e) => {
    if (e.target === burgerMenu) {
        burgerMenu.classList.add('hidden');
        burgerMenu.classList.remove('flex');
    }
  });
}