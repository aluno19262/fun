/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/assets/core/js/custom/documentation/general/draggable/swappable.js":
/*!**************************************************************************************!*\
  !*** ./resources/assets/core/js/custom/documentation/general/draggable/swappable.js ***!
  \**************************************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTDraggableSwappable = function () {\n  // Private functions\n  var exampleSwappable = function exampleSwappable() {\n    var containers = document.querySelectorAll('.draggable-zone');\n\n    if (containers.length === 0) {\n      return false;\n    }\n\n    var swappable = new Swappable[\"default\"](containers, {\n      draggable: '.draggable',\n      handle: '.draggable .draggable-handle',\n      mirror: {\n        //appendTo: selector,\n        appendTo: 'body',\n        constrainDimensions: true\n      }\n    });\n  };\n\n  return {\n    // Public Functions\n    init: function init() {\n      exampleSwappable();\n    }\n  };\n}(); // On document ready\n\n\nKTUtil.onDOMContentLoaded(function () {\n  KTDraggableSwappable.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2NvcmUvanMvY3VzdG9tL2RvY3VtZW50YXRpb24vZ2VuZXJhbC9kcmFnZ2FibGUvc3dhcHBhYmxlLmpzLmpzIiwibWFwcGluZ3MiOiJDQUVBOztBQUNBLElBQUlBLG9CQUFvQixHQUFHLFlBQVc7QUFDbEM7QUFDQSxNQUFJQyxnQkFBZ0IsR0FBRyxTQUFuQkEsZ0JBQW1CLEdBQVc7QUFDOUIsUUFBSUMsVUFBVSxHQUFHQyxRQUFRLENBQUNDLGdCQUFULENBQTBCLGlCQUExQixDQUFqQjs7QUFFQSxRQUFJRixVQUFVLENBQUNHLE1BQVgsS0FBc0IsQ0FBMUIsRUFBNkI7QUFDekIsYUFBTyxLQUFQO0FBQ0g7O0FBRUQsUUFBSUMsU0FBUyxHQUFHLElBQUlDLFNBQVMsV0FBYixDQUFzQkwsVUFBdEIsRUFBa0M7QUFDOUNNLE1BQUFBLFNBQVMsRUFBRSxZQURtQztBQUU5Q0MsTUFBQUEsTUFBTSxFQUFFLDhCQUZzQztBQUc5Q0MsTUFBQUEsTUFBTSxFQUFFO0FBQ0o7QUFDQUMsUUFBQUEsUUFBUSxFQUFFLE1BRk47QUFHSkMsUUFBQUEsbUJBQW1CLEVBQUU7QUFIakI7QUFIc0MsS0FBbEMsQ0FBaEI7QUFTSCxHQWhCRDs7QUFrQkEsU0FBTztBQUNIO0FBQ0FDLElBQUFBLElBQUksRUFBRSxnQkFBVztBQUNiWixNQUFBQSxnQkFBZ0I7QUFDbkI7QUFKRSxHQUFQO0FBTUgsQ0ExQjBCLEVBQTNCLEMsQ0E0QkE7OztBQUNBYSxNQUFNLENBQUNDLGtCQUFQLENBQTBCLFlBQVc7QUFDakNmLEVBQUFBLG9CQUFvQixDQUFDYSxJQUFyQjtBQUNILENBRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2NvcmUvanMvY3VzdG9tL2RvY3VtZW50YXRpb24vZ2VuZXJhbC9kcmFnZ2FibGUvc3dhcHBhYmxlLmpzPzY2NmQiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG5cbi8vIENsYXNzIGRlZmluaXRpb25cbnZhciBLVERyYWdnYWJsZVN3YXBwYWJsZSA9IGZ1bmN0aW9uKCkge1xuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXG4gICAgdmFyIGV4YW1wbGVTd2FwcGFibGUgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIGNvbnRhaW5lcnMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcuZHJhZ2dhYmxlLXpvbmUnKTtcblxuICAgICAgICBpZiAoY29udGFpbmVycy5sZW5ndGggPT09IDApIHtcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciBzd2FwcGFibGUgPSBuZXcgU3dhcHBhYmxlLmRlZmF1bHQoY29udGFpbmVycywge1xuICAgICAgICAgICAgZHJhZ2dhYmxlOiAnLmRyYWdnYWJsZScsXG4gICAgICAgICAgICBoYW5kbGU6ICcuZHJhZ2dhYmxlIC5kcmFnZ2FibGUtaGFuZGxlJyxcbiAgICAgICAgICAgIG1pcnJvcjoge1xuICAgICAgICAgICAgICAgIC8vYXBwZW5kVG86IHNlbGVjdG9yLFxuICAgICAgICAgICAgICAgIGFwcGVuZFRvOiAnYm9keScsXG4gICAgICAgICAgICAgICAgY29uc3RyYWluRGltZW5zaW9uczogdHJ1ZVxuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICByZXR1cm4ge1xuICAgICAgICAvLyBQdWJsaWMgRnVuY3Rpb25zXG4gICAgICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgZXhhbXBsZVN3YXBwYWJsZSgpO1xuICAgICAgICB9XG4gICAgfTtcbn0oKTtcblxuLy8gT24gZG9jdW1lbnQgcmVhZHlcbktUVXRpbC5vbkRPTUNvbnRlbnRMb2FkZWQoZnVuY3Rpb24oKSB7XG4gICAgS1REcmFnZ2FibGVTd2FwcGFibGUuaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1REcmFnZ2FibGVTd2FwcGFibGUiLCJleGFtcGxlU3dhcHBhYmxlIiwiY29udGFpbmVycyIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvckFsbCIsImxlbmd0aCIsInN3YXBwYWJsZSIsIlN3YXBwYWJsZSIsImRyYWdnYWJsZSIsImhhbmRsZSIsIm1pcnJvciIsImFwcGVuZFRvIiwiY29uc3RyYWluRGltZW5zaW9ucyIsImluaXQiLCJLVFV0aWwiLCJvbkRPTUNvbnRlbnRMb2FkZWQiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/assets/core/js/custom/documentation/general/draggable/swappable.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/core/js/custom/documentation/general/draggable/swappable.js"]();
/******/ 	
/******/ })()
;