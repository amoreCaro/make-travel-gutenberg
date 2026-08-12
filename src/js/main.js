import { estimateSinglePostReadTime } from "./components/estimateSinglePostReadTime.js";
import { calculateTotalPages } from "./components/calculateTotalPages.js";
import { burgerMenu } from "./components/burgerMenu.js";
import { tabs } from './components/tabs.js';
import { themeToggle } from './components/themeHandler.js';
import { video } from './components/video.js';
import { videoBanner } from './components/videoBanner.js';
import { slider } from './components/slider.js';
import { postVideo } from './components/postVideo.js';
import { lazyLoadImages } from './components/lazyImages.js';

document.addEventListener('DOMContentLoaded', function() {
  lazyLoadImages();
  video();
  videoBanner();
  slider();
  postVideo();
  themeToggle();
  tabs();
  calculateTotalPages();
  burgerMenu();
  estimateSinglePostReadTime();
});