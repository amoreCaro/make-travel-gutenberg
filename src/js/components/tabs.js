// Toggle menu visibility.
// If another menu is open, close it before opening the clicked one.
function toggleMenu(clickedMenu, clickedBtn) {
  // All available menus
  const menus = [
    document.querySelector('.media-menu__tags'),
    document.querySelector('.media-menu__navigation')
  ];
    // All menu buttons
  const buttons = [
    document.querySelector('.media-menu__categories-btn'),
    document.querySelector('.media-menu__tags-btn')
  ];
  // Check if the clicked menu is already open
  const isAlreadyOpen = clickedMenu.classList.contains('show');

  // Close all menus
  menus.forEach(menu => menu?.classList.remove('show'));
  // Remove active state from all buttons
  buttons.forEach(btn => btn?.classList.remove('active'));

  // If the menu was closed — open it
  if (!isAlreadyOpen) {
    clickedMenu.classList.add('show');
    clickedBtn.classList.add('active');
  }
}

/**
 * Switch tabs items
 */
function initTabsSwitch() {
  const tabs = document.querySelectorAll('.media-menu__tab');

  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();

      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
}

/**
 * Initialize menu open/close logic
 */
function initMenu() {
  const tagsBtn = document.querySelector('.media-menu__tags-btn');
  const tagsMenu = document.querySelector('.media-menu__tags');

  const categoriesBtn = document.querySelector('.media-menu__categories-btn');
  const categoriesMenu = document.querySelector('.media-menu__navigation');

  tagsBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleMenu(tagsMenu, tagsBtn);
  });

  categoriesBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleMenu(categoriesMenu, categoriesBtn);
  });
}

function enableTabRedirect(selector) {
    const tabs = document.querySelectorAll(selector);

    tabs.forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault(); // зупиняємо стандартну поведінку
            const url = tab.getAttribute('href'); // беремо URL з href
            if (url) {
                window.location.href = url; // редірект
            }
        });
    });
}

// function handleMediaMenuScroll() {
//   const menu = document.querySelector('.media-menu');
//   if (!menu) return;

//   // Визначаємо початкову точку, де знаходиться меню
//   const stickyPoint = menu.offsetTop;

//   window.addEventListener('scroll', () => {
//     // Якщо проскролили більше, ніж позиція меню — додаємо клас
//     if (window.scrollY > stickyPoint) {
//       menu.classList.add('h-fixed');
//     } else {
//       menu.classList.remove('h-fixed');
//     }
//   });
// }


export function tabs() {
  initMenu();
  initTabsSwitch();
  enableTabRedirect('.media-menu__tab'); 
  // handleMediaMenuScroll(); 
}