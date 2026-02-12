/**
 * Логіка відкриття/закриття мобільного меню
 */
function toggleMenu(clickedMenu, clickedBtn) {
  // Всі меню
  const menus = [
    document.querySelector('.media-menu__tags'),
    document.querySelector('.media-menu__navigation')
  ];

  // Всі кнопки
  const buttons = [
    document.querySelector('.media-menu__btn--category'),
    document.querySelector('.media-menu__btn')
  ];

  // Визначаємо, чи зараз меню вже відкрито
  const isAlreadyOpen = clickedMenu.classList.contains('show');

  // Закриваємо всі меню та знімаємо active з усіх кнопок
  menus.forEach(menu => menu.classList.remove('show'));
  buttons.forEach(btn => btn.classList.remove('active'));

  // Якщо меню не було відкрито, відкриваємо його та ставимо active на кнопку
  if (!isAlreadyOpen) {
    clickedMenu.classList.add('show');
    clickedBtn.classList.add('active');
  }
}

function initMenuToggle() {
  const btn = document.querySelector('.media-menu__btn');
  const wrapper = document.querySelector('.media-menu__tags');

  if (!btn || !wrapper || btn.dataset.initialized === "true") return;

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    btn.classList.toggle('active');
    wrapper.classList.toggle('show');
  });

  btn.dataset.initialized = "true";
}

/**
 * Логіка перемикання активного стану кнопок (кольорів та ліній)
 */
function updateTabVisuals(activeTab, allTabs) {
  allTabs.forEach(t => {
    const underline = t.nextElementSibling;
    const isActive = t === activeTab;

    t.classList.toggle('text-black', isActive);
    t.classList.toggle('text-[#9395ab]', !isActive);

    if (underline) {
      underline.classList.toggle('hidden', !isActive);
    }
  });
}

function toggleCategoryMobileMenu() {
  const btn = document.querySelector('.media-menu__btn--category');
  const categories = document.querySelector('.media-menu__navigation');

  if (!btn || !categories || btn.dataset.initialized === "true") return;

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    btn.classList.toggle('active');
    categories.classList.toggle('show');
  });

  btn.dataset.initialized = "true";
}

/**
 * Логіка перемикання контенту
 */
function initTabsSwitch() {
  const tabs = document.querySelectorAll('[data-tab]');

  if (!tabs.length) return;

  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      const target = tab.dataset.tab;

      updateTabVisuals(tab, tabs);
    });
  });
}


/**
 * Головний виклик
 */
export function tabs() {
  initMenuToggle();
  initTabsSwitch();
  toggleCategoryMobileMenu();
  toggleMenu();
}