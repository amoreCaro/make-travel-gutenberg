/**
 * Apply theme
 */
function applyTheme(isDark, html, toggle) {
  html.classList.toggle('dark', isDark);
  toggle.checked = isDark;
  localStorage.setItem('theme', isDark ? 'dark' : 'light');
}

/**
 * Init theme on page load
 */
function initTheme(toggle, html) {
  const savedTheme = localStorage.getItem('theme');
  const isDark = savedTheme === 'dark';

  applyTheme(isDark, html, toggle);
}

/**
 * Init toggle handler
 */
function initThemeToggle(toggle, html) {
  toggle?.addEventListener('change', () => {
    applyTheme(toggle.checked, html, toggle);
  });
}

/**
 * Public initializer
 */
export function themeToggle() {
  const toggle = document.getElementById('theme-toggle');
  const html = document.documentElement;

  if (!toggle) return;

  initTheme(toggle, html);
  initThemeToggle(toggle, html);
}
