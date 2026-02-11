/**
 * Логіка відкриття/закриття мобільного меню
 */
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

/**
 * Логіка перемикання контенту
 */
function initTabsSwitch() {
  const tabs = document.querySelectorAll('[data-tab]');
  const contents = document.querySelectorAll('[data-tags]');

  if (!tabs.length) return;

  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      const target = tab.dataset.tab;

      updateTabVisuals(tab, tabs);

      contents.forEach(content => {
        content.classList.toggle('hidden', content.dataset.tags !== target);
      });
    });
  });
}

/**
 * Головний виклик
 */
export function tabs() {
  initMenuToggle();
  initTabsSwitch();
}