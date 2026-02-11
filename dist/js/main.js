/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/components/burgerMenu.js"
/*!*****************************************!*\
  !*** ./src/js/components/burgerMenu.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   burgerMenu: () => (/* binding */ burgerMenu)\n/* harmony export */ });\nfunction burgerMenu() {\n    const burgerMenu = document.getElementById('burgerMenu');\n    const openBtn = document.getElementById('openBurgerBtn'); \n    const closeBtn = document.getElementById('closeBurger');\n    const overlay = document.getElementById('burgerOverlay');\n\n  openBtn.addEventListener('click', () => {\n    console.log(\"clicked open button\");\n    burgerMenu.classList.remove('hidden');\n    burgerMenu.classList.add('flex');\n    document.body.classList.add(\"overflow-y-hidden\");\n  });\n\n  closeBtn.addEventListener('click', () => {\n    burgerMenu.classList.add('hidden');\n    burgerMenu.classList.remove('flex');\n    document.body.classList.remove(\"overflow-y-hidden\");\n  });\n\n  // Закриття при натисканні поза контейнером\n  burgerMenu.addEventListener('click', (e) => {\n    if (e.target === burgerMenu) {\n        burgerMenu.classList.add('hidden');\n        burgerMenu.classList.remove('flex');\n    }\n  });\n}\n\n//# sourceURL=webpack:///./src/js/components/burgerMenu.js?\n}");

/***/ },

/***/ "./src/js/components/calculateTotalPages.js"
/*!**************************************************!*\
  !*** ./src/js/components/calculateTotalPages.js ***!
  \**************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   calculateTotalPages: () => (/* binding */ calculateTotalPages)\n/* harmony export */ });\n// Файл: countPages.js (або .ts)\nfunction calculateTotalPages() {\n  // Знаходимо всі елементи page-item всередині pages-list\n  const pageItems = document.querySelectorAll('.pages-list .page-item');\n\n  // Знаходимо span для виведення числа\n  const totalPagesSpan = document.querySelector('.total-pages-number');\n\n  if (totalPagesSpan) {\n    totalPagesSpan.textContent = pageItems.length.toString();\n  }\n}\n\n//# sourceURL=webpack:///./src/js/components/calculateTotalPages.js?\n}");

/***/ },

/***/ "./src/js/components/estimateSinglePostReadTime.js"
/*!*********************************************************!*\
  !*** ./src/js/components/estimateSinglePostReadTime.js ***!
  \*********************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   estimateSinglePostReadTime: () => (/* binding */ estimateSinglePostReadTime)\n/* harmony export */ });\nfunction estimateSinglePostReadTime() {\n  const post = document.querySelector('.single-post');\n  const readTimeEl = document.querySelector('.single-post__read-time');\n\n  // Text calculation\n  const text = post.innerText || '';\n  const words = text.trim().split(/\\s+/).length; // count words\n  const readingSpeed = 200; // words per minute\n  let timeMinutes = words / readingSpeed;\n\n  // Images calculation\n  const images = post.querySelectorAll('img').length;\n  const imageTime = images * 10; // 10 seconds per image\n  timeMinutes += imageTime / 60; // convert seconds to minutes\n\n  // Round to nearest minute\n  const roundedTime = Math.max(1, Math.round(timeMinutes));\n\n  //  Update the element\n  readTimeEl.textContent = `${roundedTime} min read`;\n}\n\n//# sourceURL=webpack:///./src/js/components/estimateSinglePostReadTime.js?\n}");

/***/ },

/***/ "./src/js/components/searchPopup.js"
/*!******************************************!*\
  !*** ./src/js/components/searchPopup.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   searchPopup: () => (/* binding */ searchPopup)\n/* harmony export */ });\nfunction searchPopup() {\n  const openBtn = document.getElementById('openSearch');\n  const closeBtn = document.getElementById('closeSearch');\n  const popup = document.getElementById('searchPopup');\n  const searchPopupOverlay = document.getElementById('searchPopupOverlay');\n\n  openBtn.addEventListener('click', () => {\n    console.log(\"clicked open button\");\n    popup.classList.remove('hidden');\n    popup.classList.add('flex');\n    document.body.classList.add(\"overflow-y-hidden\");\n  });\n\n  closeBtn.addEventListener('click', () => {\n    popup.classList.add('hidden');\n    popup.classList.remove('flex');\n    document.body.classList.remove(\"overflow-y-hidden\");\n  });\n\n  searchPopupOverlay.addEventListener('click', () => {\n    popup.classList.add('hidden');\n    popup.classList.remove('flex');\n    document.body.classList.remove(\"overflow-y-hidden\");\n  });\n\n  // Закриття при натисканні поза контейнером\n  popup.addEventListener('click', (e) => {\n    if (e.target === popup) {\n        popup.classList.add('hidden');\n        popup.classList.remove('flex');\n    }\n  });\n}\n\n//# sourceURL=webpack:///./src/js/components/searchPopup.js?\n}");

/***/ },

/***/ "./src/js/components/tabs.js"
/*!***********************************!*\
  !*** ./src/js/components/tabs.js ***!
  \***********************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   initTabs: () => (/* binding */ initTabs)\n/* harmony export */ });\n// Функція для скидання стану вкладок\nfunction resetTabs(tabLinks, tabUnderlines) {\n  tabLinks.forEach((link, i) => {\n    link.classList.remove('text-black', 'active');\n    link.classList.add('text-[#9395ab]');\n    tabUnderlines[i].classList.add('hidden');\n  });\n}\n\n// Функція для показу тегів для конкретної вкладки\nfunction showTagsForTab(tab, btnTags, tagsContainer) {\n  document.querySelectorAll('.tags-content').forEach(tags => {\n    if (tags.dataset.tags === tab) {\n      tags.classList.remove('hidden');\n      tags.classList.add('grid'); \n    } else {\n      tags.classList.add('hidden');\n      tags.classList.remove('grid');\n    }\n  });\n\n  // Клас active на кнопці відповідає видимості тегів\n  if ([...btnTags].some(btn => btn.classList.contains('active'))) {\n    tagsContainer.classList.remove('hidden');\n  } else {\n    tagsContainer.classList.add('hidden');\n  }\n}\n\n// Функція для додавання active кнопці\nfunction addActiveBtn(btnTags, tagsContainer) {\n  btnTags.forEach(btn => {\n    btn.addEventListener('click', () => {\n      btnTags.forEach(b => b.classList.remove('active'));\n      btn.classList.add('active');\n      tagsContainer.classList.add('show');\n    });\n  });\n}\n\n// Ініціалізація вкладок\nfunction initTabs() {\n  const tabLinks = document.querySelectorAll('.tab-link');\n  const tabUnderlines = document.querySelectorAll('.tab-underline');\n  const btnTags = document.querySelectorAll('.media-menu__btn');\n  const tagsContainer = document.querySelector('.media-menu__tags');\n\n  addActiveBtn(btnTags, tagsContainer); // виклик функції для кнопок\n\n  tabLinks.forEach((link, index) => {\n    link.addEventListener('click', (e) => {\n      e.preventDefault();\n\n      resetTabs(tabLinks, tabUnderlines); // виклик resetTabs\n      link.classList.add('text-black', 'active');\n      tabUnderlines[index].classList.remove('hidden');\n\n      showTagsForTab(link.dataset.tab, btnTags, tagsContainer); // виклик showTagsForTab\n    });\n  });\n}\n\n\n//# sourceURL=webpack:///./src/js/components/tabs.js?\n}");

/***/ },

/***/ "./src/js/main.js"
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_estimateSinglePostReadTime_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/estimateSinglePostReadTime.js */ \"./src/js/components/estimateSinglePostReadTime.js\");\n/* harmony import */ var _components_calculateTotalPages_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/calculateTotalPages.js */ \"./src/js/components/calculateTotalPages.js\");\n/* harmony import */ var _components_burgerMenu_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/burgerMenu.js */ \"./src/js/components/burgerMenu.js\");\n/* harmony import */ var _components_searchPopup_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/searchPopup.js */ \"./src/js/components/searchPopup.js\");\n/* harmony import */ var _components_tabs_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/tabs.js */ \"./src/js/components/tabs.js\");\n\n\n\n\n\n\ndocument.addEventListener('DOMContentLoaded', function() {\n  console.log(\"Main js loaded\");\n  (0,_components_tabs_js__WEBPACK_IMPORTED_MODULE_4__.initTabs)();\n  (0,_components_calculateTotalPages_js__WEBPACK_IMPORTED_MODULE_1__.calculateTotalPages)();\n  (0,_components_burgerMenu_js__WEBPACK_IMPORTED_MODULE_2__.burgerMenu)();\n  (0,_components_searchPopup_js__WEBPACK_IMPORTED_MODULE_3__.searchPopup)();\n  (0,_components_estimateSinglePostReadTime_js__WEBPACK_IMPORTED_MODULE_0__.estimateSinglePostReadTime)();\n});\n\n//# sourceURL=webpack:///./src/js/main.js?\n}");

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Check if module exists (development only)
/******/ 		if (__webpack_modules__[moduleId] === undefined) {
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/js/main.js");
/******/ 	
/******/ })()
;