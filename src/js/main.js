import { estimateSinglePostReadTime } from "./components/estimateSinglePostReadTime.js";
import { calculateTotalPages } from "./components/calculateTotalPages.js";
import { burgerMenu } from "./components/burgerMenu.js";
import { searchPopup } from "./components/searchPopup.js";
import { tabs } from './components/tabs.js';
import { themeToggle } from './components/themeHandler.js';

document.addEventListener('DOMContentLoaded', function() {
  //   const toggle = document.getElementById('theme-toggle');
  // const html = document.documentElement;

  // // init theme on load
  // const savedTheme = localStorage.getItem('theme');

  // if (savedTheme === 'dark') {
  //   html.classList.add('dark');
  //   toggle.checked = true;
  // } else {
  //   html.classList.remove('dark');
  //   toggle.checked = false;
  // }

  // // toggle handler
  // toggle.addEventListener('change', () => {
  //   if (toggle.checked) {
  //     html.classList.add('dark');
  //     localStorage.setItem('theme', 'dark');
  //   } else {
  //     html.classList.remove('dark');
  //     localStorage.setItem('theme', 'light');
  //   }
  // });
  themeToggle();
  tabs();
  calculateTotalPages();
  burgerMenu();
  searchPopup();
  estimateSinglePostReadTime();
});