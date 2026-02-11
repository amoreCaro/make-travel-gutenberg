// Функція для скидання стану вкладок
function resetTabs(tabLinks, tabUnderlines) {
  tabLinks.forEach((link, i) => {
    link.classList.remove('text-black', 'active');
    link.classList.add('text-[#9395ab]');
    tabUnderlines[i].classList.add('hidden');
  });
}

// Функція для показу тегів для конкретної вкладки
function showTagsForTab(tab, btnTags, tagsContainer) {
  document.querySelectorAll('.tags-content').forEach(tags => {
    if (tags.dataset.tags === tab) {
      tags.classList.remove('hidden');
      tags.classList.add('grid'); 
    } else {
      tags.classList.add('hidden');
      tags.classList.remove('grid');
    }
  });

  // Клас active на кнопці відповідає видимості тегів
  if ([...btnTags].some(btn => btn.classList.contains('active'))) {
    tagsContainer.classList.remove('hidden');
  } else {
    tagsContainer.classList.add('hidden');
  }
}

// Функція для додавання active кнопці
function addActiveBtn(btnTags, tagsContainer) {
  btnTags.forEach(btn => {
    btn.addEventListener('click', () => {
      btnTags.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      tagsContainer.classList.add('show');
    });
  });
}

// Ініціалізація вкладок
export function initTabs() {
  const tabLinks = document.querySelectorAll('.tab-link');
  const tabUnderlines = document.querySelectorAll('.tab-underline');
  const btnTags = document.querySelectorAll('.media-menu__btn');
  const tagsContainer = document.querySelector('.media-menu__tags');

  addActiveBtn(btnTags, tagsContainer); // виклик функції для кнопок

  tabLinks.forEach((link, index) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();

      resetTabs(tabLinks, tabUnderlines); // виклик resetTabs
      link.classList.add('text-black', 'active');
      tabUnderlines[index].classList.remove('hidden');

      showTagsForTab(link.dataset.tab, btnTags, tagsContainer); // виклик showTagsForTab
    });
  });
}
