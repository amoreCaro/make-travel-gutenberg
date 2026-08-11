export function calculateTotalPages() {
  // Знаходимо всі елементи page-item всередині pages-list
  const pageItems = document.querySelectorAll('.pages-list .page-item');

  // Знаходимо span для виведення числа
  const totalPagesSpan = document.querySelector('.total-pages-number');

  if (totalPagesSpan) {
    totalPagesSpan.textContent = pageItems.length.toString();
  }
}