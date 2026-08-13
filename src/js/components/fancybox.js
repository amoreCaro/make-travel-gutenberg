const root = document.getElementById('fancybox');
const imageEl = document.getElementById('fancyboxImage');
const captionEl = document.getElementById('fancyboxCaption');
const currentEl = root?.querySelector('[data-fancybox-current]');
const totalEl = root?.querySelector('[data-fancybox-total]');
const btnBack = document.getElementById('fancyboxBack');
const btnPrev = document.getElementById('fancyboxPrev');
const btnNext = document.getElementById('fancyboxNext');

let items = [];
let index = 0;

function prepareArticleImages() {
  document.querySelectorAll('.h-article img').forEach((img) => {
    if (img.closest('a[data-fancybox]')) return;

    const parentLink = img.closest('a');
    const src = img.currentSrc || img.getAttribute('data-src') || img.src;
    if (!src) return;

    if (parentLink) {
      const href = parentLink.getAttribute('href') || '';
      const looksLikeImage = /\.(jpe?g|png|gif|webp|avif|svg)(\?|$)/i.test(href);
      if (looksLikeImage || href === src || href === img.src) {
        parentLink.setAttribute('data-fancybox', 'article');
        if (img.alt) parentLink.setAttribute('data-caption', img.alt);
      }
      return;
    }

    const a = document.createElement('a');
    a.href = src;
    a.setAttribute('data-fancybox', 'article');
    if (img.alt) a.setAttribute('data-caption', img.alt);
    a.className = 'fancybox-trigger cursor-pointer';
    img.parentNode.insertBefore(a, img);
    a.appendChild(img);
  });
}

function update() {
  const item = items[index];
  if (!item || !imageEl) return;

  imageEl.src = item.src;
  imageEl.alt = item.alt || '';
  if (captionEl) captionEl.textContent = item.caption || '';
  if (currentEl) currentEl.textContent = String(index + 1);
  if (totalEl) totalEl.textContent = String(items.length);

  if (btnPrev) btnPrev.disabled = index <= 0;
  if (btnNext) btnNext.disabled = index >= items.length - 1;
}

function openGallery(group, startEl) {
  if (!root) return;

  const links = Array.from(
    document.querySelectorAll(`a[data-fancybox="${CSS.escape(group)}"]`)
  );

  items = links.map((link) => {
    const img = link.querySelector('img');
    return {
      src: link.href,
      caption: link.getAttribute('data-caption') || img?.alt || '',
      alt: img?.alt || '',
    };
  });

  index = Math.max(0, links.indexOf(startEl));
  if (index < 0) index = 0;

  root.hidden = false;
  requestAnimationFrame(() => {
    root.classList.add('is-open');
  });
  document.body.classList.add('overflow-y-hidden');
  update();
}

function closeGallery() {
  if (!root) return;

  root.classList.remove('is-open');
  document.body.classList.remove('overflow-y-hidden');

  const onEnd = () => {
    root.hidden = true;
    if (imageEl) imageEl.removeAttribute('src');
    root.removeEventListener('transitionend', onEnd);
  };

  root.addEventListener('transitionend', onEnd);
}

function goPrev() {
  if (index <= 0) return;
  index -= 1;
  update();
}

function goNext() {
  if (index >= items.length - 1) return;
  index += 1;
  update();
}

function initTriggers() {
  document.addEventListener('click', (e) => {
    const link = e.target.closest?.('a[data-fancybox]');
    if (!link) return;

    e.preventDefault();
    const group = link.getAttribute('data-fancybox') || 'gallery';
    openGallery(group, link);
  });
}

function initControls() {
  if (!root) return;

  if (btnBack) {
    btnBack.addEventListener('click', (e) => {
      e.preventDefault();
      closeGallery();
    });
  }

  if (btnPrev) {
    btnPrev.addEventListener('click', (e) => {
      e.preventDefault();
      goPrev();
    });
  }

  if (btnNext) {
    btnNext.addEventListener('click', (e) => {
      e.preventDefault();
      goNext();
    });
  }

  root.addEventListener('click', (e) => {
    if (e.target === root) closeGallery();
  });

  document.addEventListener('keydown', (e) => {
    if (!root.classList.contains('is-open')) return;
    if (e.key === 'Escape') closeGallery();
    if (e.key === 'ArrowLeft') goPrev();
    if (e.key === 'ArrowRight') goNext();
  });
}

export function fancybox() {
  prepareArticleImages();
  initTriggers();
  initControls();
}
