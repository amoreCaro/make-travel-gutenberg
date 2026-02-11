import { estimateSinglePostReadTime } from "./components/estimateSinglePostReadTime.js";
import { calculateTotalPages } from "./components/calculateTotalPages.js";
import { burgerMenu } from "./components/burgerMenu.js";
import { searchPopup } from "./components/searchPopup.js";
import { initTabs } from './components/tabs.js';

document.addEventListener('DOMContentLoaded', function() {
  console.log("Main js loaded");
  initTabs();
  calculateTotalPages();
  burgerMenu();
  searchPopup();
  estimateSinglePostReadTime();
});