export function searchPopup() {
  const openBtn = document.getElementById('openSearch');
  const closeBtn = document.getElementById('closeSearch');
  const popup = document.getElementById('searchPopup');
  const searchPopupOverlay = document.getElementById('searchPopupOverlay');

  openBtn.addEventListener('click', () => {
    popup.classList.remove('hidden');
    popup.classList.add('flex');
    document.body.classList.add("overflow-y-hidden");
  });

  closeBtn.addEventListener('click', () => {
    popup.classList.add('hidden');
    popup.classList.remove('flex');
    document.body.classList.remove("overflow-y-hidden");
  });

  searchPopupOverlay.addEventListener('click', () => {
    popup.classList.add('hidden');
    popup.classList.remove('flex');
    document.body.classList.remove("overflow-y-hidden");
  });

  // Закриття при натисканні поза контейнером
  popup.addEventListener('click', (e) => {
    if (e.target === popup) {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
    }
  });
}