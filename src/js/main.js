import { estimateSinglePostReadTime } from "./components/estimateSinglePostReadTime.js";
import { calculateTotalPages } from "./components/calculateTotalPages.js";
import { burgerMenu } from "./components/burgerMenu.js";
import { searchPopup } from "./components/searchPopup.js";
import { tabs } from './components/tabs.js';

document.addEventListener('DOMContentLoaded', function() {
  tabs();
  calculateTotalPages();
  burgerMenu();
  searchPopup();
  estimateSinglePostReadTime();
});