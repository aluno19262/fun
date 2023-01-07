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

/***/ "./resources/assets/extended/js/custom/account/settings/signin-methods.js":
/*!********************************************************************************!*\
  !*** ./resources/assets/extended/js/custom/account/settings/signin-methods.js ***!
  \********************************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTAccountSettingsSigninMethods = function () {\n  // Private functions\n  var initSettings = function initSettings() {\n    // UI elements\n    var signInMainEl = document.getElementById('kt_signin_email');\n    var signInEditEl = document.getElementById('kt_signin_email_edit');\n    var passwordMainEl = document.getElementById('kt_signin_password');\n    var passwordEditEl = document.getElementById('kt_signin_password_edit'); // button elements\n\n    var signInChangeEmail = document.getElementById('kt_signin_email_button');\n    var signInCancelEmail = document.getElementById('kt_signin_cancel');\n    var passwordChange = document.getElementById('kt_signin_password_button');\n    var passwordCancel = document.getElementById('kt_password_cancel'); // toggle UI\n\n    signInChangeEmail.querySelector('button').addEventListener('click', function () {\n      toggleChangeEmail();\n    });\n    signInCancelEmail.addEventListener('click', function () {\n      toggleChangeEmail();\n    });\n    passwordChange.querySelector('button').addEventListener('click', function () {\n      toggleChangePassword();\n    });\n    passwordCancel.addEventListener('click', function () {\n      toggleChangePassword();\n    });\n\n    var toggleChangeEmail = function toggleChangeEmail() {\n      signInMainEl.classList.toggle('d-none');\n      signInChangeEmail.classList.toggle('d-none');\n      signInEditEl.classList.toggle('d-none');\n    };\n\n    var toggleChangePassword = function toggleChangePassword() {\n      passwordMainEl.classList.toggle('d-none');\n      passwordChange.classList.toggle('d-none');\n      passwordEditEl.classList.toggle('d-none');\n    };\n  };\n\n  var handleChangeEmail = function handleChangeEmail(e) {\n    var validation; // form elements\n\n    var form = document.getElementById('kt_signin_change_email');\n    var submitButton = form.querySelector('#kt_signin_submit');\n    validation = FormValidation.formValidation(form, {\n      fields: {\n        email: {\n          validators: {\n            notEmpty: {\n              message: 'Email is required'\n            },\n            emailAddress: {\n              message: 'The value is not a valid email address'\n            }\n          }\n        },\n        password: {\n          validators: {\n            notEmpty: {\n              message: 'Password is required'\n            }\n          }\n        }\n      },\n      plugins: {\n        //Learn more: https://formvalidation.io/guide/plugins\n        trigger: new FormValidation.plugins.Trigger(),\n        bootstrap: new FormValidation.plugins.Bootstrap5({\n          rowSelector: '.fv-row'\n        })\n      }\n    });\n    submitButton.addEventListener('click', function (e) {\n      e.preventDefault();\n      validation.validate().then(function (status) {\n        if (status === 'Valid') {\n          // Show loading indication\n          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click\n\n          submitButton.disabled = true; // Send ajax request\n\n          axios.post(form.getAttribute('action'), new FormData(form)).then(function (response) {\n            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/\n            Swal.fire({\n              text: \"Your email has been successfully changed.\",\n              icon: \"success\",\n              buttonsStyling: false,\n              confirmButtonText: \"Ok, got it!\",\n              customClass: {\n                confirmButton: \"btn font-weight-bold btn-light-primary\"\n              }\n            });\n          })[\"catch\"](function (error) {\n            var dataMessage = error.response.data.message;\n            var dataErrors = error.response.data.errors;\n\n            for (var errorsKey in dataErrors) {\n              if (!dataErrors.hasOwnProperty(errorsKey)) continue;\n              dataMessage += \"\\r\\n\" + dataErrors[errorsKey];\n            }\n\n            if (error.response) {\n              Swal.fire({\n                text: dataMessage,\n                icon: \"error\",\n                buttonsStyling: false,\n                confirmButtonText: \"Ok, got it!\",\n                customClass: {\n                  confirmButton: \"btn btn-primary\"\n                }\n              });\n            }\n          }).then(function () {\n            // always executed\n            // Hide loading indication\n            submitButton.removeAttribute('data-kt-indicator'); // Enable button\n\n            submitButton.disabled = false;\n          });\n        } else {\n          Swal.fire({\n            text: \"Sorry, looks like there are some errors detected, please try again.\",\n            icon: \"error\",\n            buttonsStyling: false,\n            confirmButtonText: \"Ok, got it!\",\n            customClass: {\n              confirmButton: \"btn font-weight-bold btn-light-primary\"\n            }\n          });\n        }\n      });\n    });\n  };\n\n  var handleChangePassword = function handleChangePassword(e) {\n    var validation; // form elements\n\n    var form = document.getElementById('kt_signin_change_password');\n    var submitButton = form.querySelector('#kt_password_submit');\n    validation = FormValidation.formValidation(form, {\n      fields: {\n        current_password: {\n          validators: {\n            notEmpty: {\n              message: 'Current Password is required'\n            }\n          }\n        },\n        password: {\n          validators: {\n            notEmpty: {\n              message: 'New Password is required'\n            }\n          }\n        },\n        password_confirmation: {\n          validators: {\n            notEmpty: {\n              message: 'Confirm Password is required'\n            },\n            identical: {\n              compare: function compare() {\n                return form.querySelector('[name=\"password\"]').value;\n              },\n              message: 'The password and its confirm are not the same'\n            }\n          }\n        }\n      },\n      plugins: {\n        //Learn more: https://formvalidation.io/guide/plugins\n        trigger: new FormValidation.plugins.Trigger(),\n        bootstrap: new FormValidation.plugins.Bootstrap5({\n          rowSelector: '.fv-row'\n        })\n      }\n    });\n    submitButton.addEventListener('click', function (e) {\n      e.preventDefault();\n      validation.validate().then(function (status) {\n        if (status == 'Valid') {\n          // Show loading indication\n          submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click\n\n          submitButton.disabled = true; // Send ajax request\n\n          axios.post(form.getAttribute('action'), new FormData(form)).then(function (response) {\n            // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/\n            Swal.fire({\n              text: \"Your password has been successfully reset.\",\n              icon: \"success\",\n              buttonsStyling: false,\n              confirmButtonText: \"Ok, got it!\",\n              customClass: {\n                confirmButton: \"btn font-weight-bold btn-light-primary\"\n              }\n            });\n          })[\"catch\"](function (error) {\n            var dataMessage = error.response.data.message;\n            var dataErrors = error.response.data.errors;\n\n            for (var errorsKey in dataErrors) {\n              if (!dataErrors.hasOwnProperty(errorsKey)) continue;\n              dataMessage += \"\\r\\n\" + dataErrors[errorsKey];\n            }\n\n            if (error.response) {\n              Swal.fire({\n                text: dataMessage,\n                icon: \"error\",\n                buttonsStyling: false,\n                confirmButtonText: \"Ok, got it!\",\n                customClass: {\n                  confirmButton: \"btn btn-primary\"\n                }\n              });\n            }\n          }).then(function () {\n            // always executed\n            // Hide loading indication\n            submitButton.removeAttribute('data-kt-indicator'); // Enable button\n\n            submitButton.disabled = false;\n          });\n        } else {\n          Swal.fire({\n            text: \"Sorry, looks like there are some errors detected, please try again.\",\n            icon: \"error\",\n            buttonsStyling: false,\n            confirmButtonText: \"Ok, got it!\",\n            customClass: {\n              confirmButton: \"btn font-weight-bold btn-light-primary\"\n            }\n          });\n        }\n      });\n    });\n  }; // Public methods\n\n\n  return {\n    init: function init() {\n      initSettings();\n      handleChangeEmail();\n      handleChangePassword();\n    }\n  };\n}(); // On document ready\n\n\nKTUtil.onDOMContentLoaded(function () {\n  KTAccountSettingsSigninMethods.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvYXNzZXRzL2V4dGVuZGVkL2pzL2N1c3RvbS9hY2NvdW50L3NldHRpbmdzL3NpZ25pbi1tZXRob2RzLmpzLmpzIiwibWFwcGluZ3MiOiJDQUVBOztBQUNBLElBQUlBLDhCQUE4QixHQUFHLFlBQVk7QUFDN0M7QUFDQSxNQUFJQyxZQUFZLEdBQUcsU0FBZkEsWUFBZSxHQUFZO0FBRTNCO0FBQ0EsUUFBSUMsWUFBWSxHQUFHQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsaUJBQXhCLENBQW5CO0FBQ0EsUUFBSUMsWUFBWSxHQUFHRixRQUFRLENBQUNDLGNBQVQsQ0FBd0Isc0JBQXhCLENBQW5CO0FBQ0EsUUFBSUUsY0FBYyxHQUFHSCxRQUFRLENBQUNDLGNBQVQsQ0FBd0Isb0JBQXhCLENBQXJCO0FBQ0EsUUFBSUcsY0FBYyxHQUFHSixRQUFRLENBQUNDLGNBQVQsQ0FBd0IseUJBQXhCLENBQXJCLENBTjJCLENBUTNCOztBQUNBLFFBQUlJLGlCQUFpQixHQUFHTCxRQUFRLENBQUNDLGNBQVQsQ0FBd0Isd0JBQXhCLENBQXhCO0FBQ0EsUUFBSUssaUJBQWlCLEdBQUdOLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixrQkFBeEIsQ0FBeEI7QUFDQSxRQUFJTSxjQUFjLEdBQUdQLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QiwyQkFBeEIsQ0FBckI7QUFDQSxRQUFJTyxjQUFjLEdBQUdSLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixvQkFBeEIsQ0FBckIsQ0FaMkIsQ0FjM0I7O0FBQ0FJLElBQUFBLGlCQUFpQixDQUFDSSxhQUFsQixDQUFnQyxRQUFoQyxFQUEwQ0MsZ0JBQTFDLENBQTJELE9BQTNELEVBQW9FLFlBQVk7QUFDNUVDLE1BQUFBLGlCQUFpQjtBQUNwQixLQUZEO0FBSUFMLElBQUFBLGlCQUFpQixDQUFDSSxnQkFBbEIsQ0FBbUMsT0FBbkMsRUFBNEMsWUFBWTtBQUNwREMsTUFBQUEsaUJBQWlCO0FBQ3BCLEtBRkQ7QUFJQUosSUFBQUEsY0FBYyxDQUFDRSxh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TUFvRE87QUFDSE0sVUFBQUEsSUFBSSxDQUFDQyxJQUFMLENBQVU7QUFDTkMsWUFBQUEsSUFBSSxFQUFFLHFFQURBO0FBRU5DLFlBQUFBLElBQUksRUFBRSxPQUZBO0FBR05DLFlBQUFBLGNBQWMsRUFBRSxLQUhWO0FBSU5DLFlBQUFBLGlCQUFpQixFQUFFLGFBSmI7QUFLTkMsWUFBQUEsV0FBVyxFQUFFO0FBQ1RDLGNBQUFBLGFBQWEsRUFBRTtBQUROO0FBTFAsV0FBVjtBQVNIO0FBQ0osT0FoRUQ7QUFpRUgsS0FwRUQ7QUFxRUgsR0F4SEQsQ0E3SjZDLENBdVI3Qzs7O0FBQ0EsU0FBTztBQUNIZSxJQUFBQSxJQUFJLEVBQUUsZ0JBQVk7QUFDZHRFLE1BQUFBLFlBQVk7QUFDWmlCLE1BQUFBLGlCQUFpQjtBQUNqQitDLE1BQUFBLG9CQUFvQjtBQUN2QjtBQUxFLEdBQVA7QUFPSCxDQS9Sb0MsRUFBckMsQyxDQWlTQTs7O0FBQ0FPLE1BQU0sQ0FBQ0Msa0JBQVAsQ0FBMEIsWUFBWTtBQUNsQ3pFLEVBQUFBLDhCQUE4QixDQUFDdUUsSUFBL0I7QUFDSCxDQUZEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9leHRlbmRlZC9qcy9jdXN0b20vYWNjb3VudC9zZXR0aW5ncy9zaWduaW4tbWV0aG9kcy5qcz8yZDQzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG4vLyBDbGFzcyBkZWZpbml0aW9uXG52YXIgS1RBY2NvdW50U2V0dGluZ3NTaWduaW5NZXRob2RzID0gZnVuY3Rpb24gKCkge1xuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXG4gICAgdmFyIGluaXRTZXR0aW5ncyA9IGZ1bmN0aW9uICgpIHtcblxuICAgICAgICAvLyBVSSBlbGVtZW50c1xuICAgICAgICB2YXIgc2lnbkluTWFpbkVsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2t0X3NpZ25pbl9lbWFpbCcpO1xuICAgICAgICB2YXIgc2lnbkluRWRpdEVsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2t0X3NpZ25pbl9lbWFpbF9lZGl0Jyk7XG4gICAgICAgIHZhciBwYXNzd29yZE1haW5FbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdrdF9zaWduaW5fcGFzc3dvcmQnKTtcbiAgICAgICAgdmFyIHBhc3N3b3JkRWRpdEVsID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2t0X3NpZ25pbl9wYXNzd29yZF9lZGl0Jyk7XG5cbiAgICAgICAgLy8gYnV0dG9uIGVsZW1lbnRzXG4gICAgICAgIHZhciBzaWduSW5DaGFuZ2VFbWFpbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdrdF9zaWduaW5fZW1haWxfYnV0dG9uJyk7XG4gICAgICAgIHZhciBzaWduSW5DYW5jZWxFbWFpbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdrdF9zaWduaW5fY2FuY2VsJyk7XG4gICAgICAgIHZhciBwYXNzd29yZENoYW5nZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdrdF9zaWduaW5fcGFzc3dvcmRfYnV0dG9uJyk7XG4gICAgICAgIHZhciBwYXNzd29yZENhbmNlbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdrdF9wYXNzd29yZF9jYW5jZWwnKTtcblxuICAgICAgICAvLyB0b2dnbGUgVUlcbiAgICAgICAgc2lnbkluQ2hhbmdlRW1haWwucXVlcnlTZWxlY3RvcignYnV0dG9uJykuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB0b2dnbGVDaGFuZ2VFbWFpbCgpO1xuICAgICAgICB9KTtcblxuICAgICAgICBzaWduSW5DYW5jZWxFbWFpbC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHRvZ2dsZUNoYW5nZUVtYWlsKCk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIHBhc3N3b3JkQ2hhbmdlLnF1ZXJ5U2VsZWN0b3IoJ2J1dHRvbicpLmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgdG9nZ2xlQ2hhbmdlUGFzc3dvcmQoKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgcGFzc3dvcmRDYW5jZWwuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICB0b2dnbGVDaGFuZ2VQYXNzd29yZCgpO1xuICAgICAgICB9KTtcblxuICAgICAgICB2YXIgdG9nZ2xlQ2hhbmdlRW1haWwgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICBzaWduSW5NYWluRWwuY2xhc3NMaXN0LnRvZ2dsZSgnZC1ub25lJyk7XG4gICAgICAgICAgICBzaWduSW5DaGFuZ2VFbWFpbC5jbGFzc0xpc3QudG9nZ2xlKCdkLW5vbmUnKTtcbiAgICAgICAgICAgIHNpZ25JbkVkaXRFbC5jbGFzc0xpc3QudG9nZ2xlKCdkLW5vbmUnKTtcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciB0b2dnbGVDaGFuZ2VQYXNzd29yZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHBhc3N3b3JkTWFpbkVsLmNsYXNzTGlzdC50b2dnbGUoJ2Qtbm9uZScpO1xuICAgICAgICAgICAgcGFzc3dvcmRDaGFuZ2UuY2xhc3NMaXN0LnRvZ2dsZSgnZC1ub25lJyk7XG4gICAgICAgICAgICBwYXNzd29yZEVkaXRFbC5jbGFzc0xpc3QudG9nZ2xlKCdkLW5vbmUnKTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHZhciBoYW5kbGVDaGFuZ2VFbWFpbCA9IGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIHZhciB2YWxpZGF0aW9uO1xuXG4gICAgICAgIC8vIGZvcm0gZWxlbWVudHNcbiAgICAgICAgdmFyIGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgna3Rfc2lnbmluX2NoYW5nZV9lbWFpbCcpO1xuICAgICAgICB2YXIgc3VibWl0QnV0dG9uID0gZm9ybS5xdWVyeVNlbGVjdG9yKCcja3Rfc2lnbmluX3N1Ym1pdCcpO1xuXG4gICAgICAgIHZhbGlkYXRpb24gPSBGb3JtVmFsaWRhdGlvbi5mb3JtVmFsaWRhdGlvbihcbiAgICAgICAgICAgIGZvcm0sXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgICAgZmllbGRzOiB7XG4gICAgICAgICAgICAgICAgICAgIGVtYWlsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YWxpZGF0b3JzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbm90RW1wdHk6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbWVzc2FnZTogJ0VtYWlsIGlzIHJlcXVpcmVkJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZW1haWxBZGRyZXNzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdUaGUgdmFsdWUgaXMgbm90IGEgdmFsaWQgZW1haWwgYWRkcmVzcydcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG5cbiAgICAgICAgICAgICAgICAgICAgcGFzc3dvcmQ6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhbGlkYXRvcnM6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBub3RFbXB0eToge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBtZXNzYWdlOiAnUGFzc3dvcmQgaXMgcmVxdWlyZWQnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgICAgIHBsdWdpbnM6IHsgLy9MZWFybiBtb3JlOiBodHRwczovL2Zvcm12YWxpZGF0aW9uLmlvL2d1aWRlL3BsdWdpbnNcbiAgICAgICAgICAgICAgICAgICAgdHJpZ2dlcjogbmV3IEZvcm1WYWxpZGF0aW9uLnBsdWdpbnMuVHJpZ2dlcigpLFxuICAgICAgICAgICAgICAgICAgICBib290c3RyYXA6IG5ldyBGb3JtVmFsaWRhdGlvbi5wbHVnaW5zLkJvb3RzdHJhcDUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgcm93U2VsZWN0b3I6ICcuZnYtcm93J1xuICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgKTtcblxuICAgICAgICBzdWJtaXRCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICB2YWxpZGF0aW9uLnZhbGlkYXRlKCkudGhlbihmdW5jdGlvbiAoc3RhdHVzKSB7XG4gICAgICAgICAgICAgICAgaWYgKHN0YXR1cyA9PT0gJ1ZhbGlkJykge1xuXG4gICAgICAgICAgICAgICAgICAgIC8vIFNob3cgbG9hZGluZyBpbmRpY2F0aW9uXG4gICAgICAgICAgICAgICAgICAgIHN1Ym1pdEJ1dHRvbi5zZXRBdHRyaWJ1dGUoJ2RhdGEta3QtaW5kaWNhdG9yJywgJ29uJyk7XG5cbiAgICAgICAgICAgICAgICAgICAgLy8gRGlzYWJsZSBidXR0b24gdG8gYXZvaWQgbXVsdGlwbGUgY2xpY2tcbiAgICAgICAgICAgICAgICAgICAgc3VibWl0QnV0dG9uLmRpc2FibGVkID0gdHJ1ZTtcblxuICAgICAgICAgICAgICAgICAgICAvLyBTZW5kIGFqYXggcmVxdWVzdFxuICAgICAgICAgICAgICAgICAgICBheGlvcy5wb3N0KGZvcm0uZ2V0QXR0cmlidXRlKCdhY3Rpb24nKSwgbmV3IEZvcm1EYXRhKGZvcm0pKVxuICAgICAgICAgICAgICAgICAgICAgICAgLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gU2hvdyBtZXNzYWdlIHBvcHVwLiBGb3IgbW9yZSBpbmZvIGNoZWNrIHRoZSBwbHVnaW4ncyBvZmZpY2lhbCBkb2N1bWVudGF0aW9uOiBodHRwczovL3N3ZWV0YWxlcnQyLmdpdGh1Yi5pby9cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB0ZXh0OiBcIllvdXIgZW1haWwgaGFzIGJlZW4gc3VjY2Vzc2Z1bGx5IGNoYW5nZWQuXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGljb246IFwic3VjY2Vzc1wiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiBcIk9rLCBnb3QgaXQhXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1c3RvbUNsYXNzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBmb250LXdlaWdodC1ib2xkIGJ0bi1saWdodC1wcmltYXJ5XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIC5jYXRjaChmdW5jdGlvbiAoZXJyb3IpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBsZXQgZGF0YU1lc3NhZ2UgPSBlcnJvci5yZXNwb25zZS5kYXRhLm1lc3NhZ2U7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbGV0IGRhdGFFcnJvcnMgPSBlcnJvci5yZXNwb25zZS5kYXRhLmVycm9ycztcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZvciAoY29uc3QgZXJyb3JzS2V5IGluIGRhdGFFcnJvcnMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFkYXRhRXJyb3JzLmhhc093blByb3BlcnR5KGVycm9yc0tleSkpIGNvbnRpbnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRhTWVzc2FnZSArPSBcIlxcclxcblwiICsgZGF0YUVycm9yc1tlcnJvcnNLZXldO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChlcnJvci5yZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogZGF0YU1lc3NhZ2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcImVycm9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY3VzdG9tQ2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBidG4tcHJpbWFyeVwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAudGhlbihmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gYWx3YXlzIGV4ZWN1dGVkXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gSGlkZSBsb2FkaW5nIGluZGljYXRpb25cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdWJtaXRCdXR0b24ucmVtb3ZlQXR0cmlidXRlKCdkYXRhLWt0LWluZGljYXRvcicpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gRW5hYmxlIGJ1dHRvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN1Ym1pdEJ1dHRvbi5kaXNhYmxlZCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogXCJTb3JyeSwgbG9va3MgbGlrZSB0aGVyZSBhcmUgc29tZSBlcnJvcnMgZGV0ZWN0ZWQsIHBsZWFzZSB0cnkgYWdhaW4uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcImVycm9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgY3VzdG9tQ2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBmb250LXdlaWdodC1ib2xkIGJ0bi1saWdodC1wcmltYXJ5XCJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIHZhciBoYW5kbGVDaGFuZ2VQYXNzd29yZCA9IGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIHZhciB2YWxpZGF0aW9uO1xuXG4gICAgICAgIC8vIGZvcm0gZWxlbWVudHNcbiAgICAgICAgdmFyIGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgna3Rfc2lnbmluX2NoYW5nZV9wYXNzd29yZCcpO1xuICAgICAgICB2YXIgc3VibWl0QnV0dG9uID0gZm9ybS5xdWVyeVNlbGVjdG9yKCcja3RfcGFzc3dvcmRfc3VibWl0Jyk7XG5cbiAgICAgICAgdmFsaWRhdGlvbiA9IEZvcm1WYWxpZGF0aW9uLmZvcm1WYWxpZGF0aW9uKFxuICAgICAgICAgICAgZm9ybSxcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICBmaWVsZHM6IHtcbiAgICAgICAgICAgICAgICAgICAgY3VycmVudF9wYXNzd29yZDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vdEVtcHR5OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdDdXJyZW50IFBhc3N3b3JkIGlzIHJlcXVpcmVkJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgICAgICAgICBwYXNzd29yZDoge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vdEVtcHR5OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdOZXcgUGFzc3dvcmQgaXMgcmVxdWlyZWQnXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9LFxuXG4gICAgICAgICAgICAgICAgICAgIHBhc3N3b3JkX2NvbmZpcm1hdGlvbjoge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFsaWRhdG9yczoge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vdEVtcHR5OiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1lc3NhZ2U6ICdDb25maXJtIFBhc3N3b3JkIGlzIHJlcXVpcmVkJ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWRlbnRpY2FsOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbXBhcmU6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiBmb3JtLnF1ZXJ5U2VsZWN0b3IoJ1tuYW1lPVwicGFzc3dvcmRcIl0nKS52YWx1ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbWVzc2FnZTogJ1RoZSBwYXNzd29yZCBhbmQgaXRzIGNvbmZpcm0gYXJlIG5vdCB0aGUgc2FtZSdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgICAgIHBsdWdpbnM6IHsgLy9MZWFybiBtb3JlOiBodHRwczovL2Zvcm12YWxpZGF0aW9uLmlvL2d1aWRlL3BsdWdpbnNcbiAgICAgICAgICAgICAgICAgICAgdHJpZ2dlcjogbmV3IEZvcm1WYWxpZGF0aW9uLnBsdWdpbnMuVHJpZ2dlcigpLFxuICAgICAgICAgICAgICAgICAgICBib290c3RyYXA6IG5ldyBGb3JtVmFsaWRhdGlvbi5wbHVnaW5zLkJvb3RzdHJhcDUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgcm93U2VsZWN0b3I6ICcuZnYtcm93J1xuICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgKTtcblxuICAgICAgICBzdWJtaXRCdXR0b24uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICB2YWxpZGF0aW9uLnZhbGlkYXRlKCkudGhlbihmdW5jdGlvbiAoc3RhdHVzKSB7XG4gICAgICAgICAgICAgICAgaWYgKHN0YXR1cyA9PSAnVmFsaWQnKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgLy8gU2hvdyBsb2FkaW5nIGluZGljYXRpb25cbiAgICAgICAgICAgICAgICAgICAgc3VibWl0QnV0dG9uLnNldEF0dHJpYnV0ZSgnZGF0YS1rdC1pbmRpY2F0b3InLCAnb24nKTtcblxuICAgICAgICAgICAgICAgICAgICAvLyBEaXNhYmxlIGJ1dHRvbiB0byBhdm9pZCBtdWx0aXBsZSBjbGlja1xuICAgICAgICAgICAgICAgICAgICBzdWJtaXRCdXR0b24uZGlzYWJsZWQgPSB0cnVlO1xuXG4gICAgICAgICAgICAgICAgICAgIC8vIFNlbmQgYWpheCByZXF1ZXN0XG4gICAgICAgICAgICAgICAgICAgIGF4aW9zLnBvc3QoZm9ybS5nZXRBdHRyaWJ1dGUoJ2FjdGlvbicpLCBuZXcgRm9ybURhdGEoZm9ybSkpXG4gICAgICAgICAgICAgICAgICAgICAgICAudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvLyBTaG93IG1lc3NhZ2UgcG9wdXAuIEZvciBtb3JlIGluZm8gY2hlY2sgdGhlIHBsdWdpbidzIG9mZmljaWFsIGRvY3VtZW50YXRpb246IGh0dHBzOi8vc3dlZXRhbGVydDIuZ2l0aHViLmlvL1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIFN3YWwuZmlyZSh7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHQ6IFwiWW91ciBwYXNzd29yZCBoYXMgYmVlbiBzdWNjZXNzZnVsbHkgcmVzZXQuXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGljb246IFwic3VjY2Vzc1wiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiBcIk9rLCBnb3QgaXQhXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGN1c3RvbUNsYXNzOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBmb250LXdlaWdodC1ib2xkIGJ0bi1saWdodC1wcmltYXJ5XCJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAgICAgICAgIC5jYXRjaChmdW5jdGlvbiAoZXJyb3IpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBsZXQgZGF0YU1lc3NhZ2UgPSBlcnJvci5yZXNwb25zZS5kYXRhLm1lc3NhZ2U7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgbGV0IGRhdGFFcnJvcnMgPSBlcnJvci5yZXNwb25zZS5kYXRhLmVycm9ycztcblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGZvciAoY29uc3QgZXJyb3JzS2V5IGluIGRhdGFFcnJvcnMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFkYXRhRXJyb3JzLmhhc093blByb3BlcnR5KGVycm9yc0tleSkpIGNvbnRpbnVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRhTWVzc2FnZSArPSBcIlxcclxcblwiICsgZGF0YUVycm9yc1tlcnJvcnNLZXldO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChlcnJvci5yZXNwb25zZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogZGF0YU1lc3NhZ2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcImVycm9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgY3VzdG9tQ2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBidG4tcHJpbWFyeVwiXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgICAgICAgICAudGhlbihmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gYWx3YXlzIGV4ZWN1dGVkXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gSGlkZSBsb2FkaW5nIGluZGljYXRpb25cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdWJtaXRCdXR0b24ucmVtb3ZlQXR0cmlidXRlKCdkYXRhLWt0LWluZGljYXRvcicpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLy8gRW5hYmxlIGJ1dHRvblxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHN1Ym1pdEJ1dHRvbi5kaXNhYmxlZCA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBTd2FsLmZpcmUoe1xuICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogXCJTb3JyeSwgbG9va3MgbGlrZSB0aGVyZSBhcmUgc29tZSBlcnJvcnMgZGV0ZWN0ZWQsIHBsZWFzZSB0cnkgYWdhaW4uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBpY29uOiBcImVycm9yXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICBidXR0b25zU3R5bGluZzogZmFsc2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uVGV4dDogXCJPaywgZ290IGl0IVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgY3VzdG9tQ2xhc3M6IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb25maXJtQnV0dG9uOiBcImJ0biBmb250LXdlaWdodC1ib2xkIGJ0bi1saWdodC1wcmltYXJ5XCJcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIC8vIFB1YmxpYyBtZXRob2RzXG4gICAgcmV0dXJuIHtcbiAgICAgICAgaW5pdDogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaW5pdFNldHRpbmdzKCk7XG4gICAgICAgICAgICBoYW5kbGVDaGFuZ2VFbWFpbCgpO1xuICAgICAgICAgICAgaGFuZGxlQ2hhbmdlUGFzc3dvcmQoKTtcbiAgICAgICAgfVxuICAgIH1cbn0oKTtcblxuLy8gT24gZG9jdW1lbnQgcmVhZHlcbktUVXRpbC5vbkRPTUNvbnRlbnRMb2FkZWQoZnVuY3Rpb24gKCkge1xuICAgIEtUQWNjb3VudFNldHRpbmdzU2lnbmluTWV0aG9kcy5pbml0KCk7XG59KTtcbiJdLCJuYW1lcyI6WyJLVEFjY291bnRTZXR0aW5nc1NpZ25pbk1ldGhvZHMiLCJpbml0U2V0dGluZ3MiLCJzaWduSW5NYWluRWwiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwic2lnbkluRWRpdEVsIiwicGFzc3dvcmRNYWluRWwiLCJwYXNzd29yZEVkaXRFbCIsInNpZ25JbkNoYW5nZUVtYWlsIiwic2lnbkluQ2FuY2VsRW1haWwiLCJwYXNzd29yZENoYW5nZSIsInBhc3N3b3JkQ2FuY2VsIiwicXVlcnlTZWxlY3RvciIsImFkZEV2ZW50TGlzdGVuZXIiLCJ0b2dnbGVDaGFuZ2VFbWFpbCIsInRvZ2dsZUNoYW5nZVBhc3N3b3JkIiwiY2xhc3NMaXN0IiwidG9nZ2xlIiwiaGFuZGxlQ2hhbmdlRW1haWwiLCJlIiwidmFsaWRhdGlvbiIsImZvcm0iLCJzdWJtaXRCdXR0b24iLCJGb3JtVmFsaWRhdGlvbiIsImZvcm1WYWxpZGF0aW9uIiwiZmllbGRzIiwiZW1haWwiLCJ2YWxpZGF0b3JzIiwibm90RW1wdHkiLCJtZXNzYWdlIiwiZW1haWxBZGRyZXNzIiwicGFzc3dvcmQiLCJwbHVnaW5zIiwidHJpZ2dlciIsIlRyaWdnZXIiLCJib290c3RyYXAiLCJCb290c3RyYXA1Iiwicm93U2VsZWN0b3IiLCJwcmV2ZW50RGVmYXVsdCIsInZhbGlkYXRlIiwidGhlbiIsInN0YXR1cyIsInNldEF0dHJpYnV0ZSIsImRpc2FibGVkIiwiYXhpb3MiLCJwb3N0IiwiZ2V0QXR0cmlidXRlIiwiRm9ybURhdGEiLCJyZXNwb25zZSIsIlN3YWwiLCJmaXJlIiwidGV4dCIsImljb24iLCJidXR0b25zU3R5bGluZyIsImNvbmZpcm1CdXR0b25UZXh0IiwiY3VzdG9tQ2xhc3MiLCJjb25maXJtQnV0dG9uIiwiZXJyb3IiLCJkYXRhTWVzc2FnZSIsImRhdGEiLCJkYXRhRXJyb3JzIiwiZXJyb3JzIiwiZXJyb3JzS2V5IiwiaGFzT3duUHJvcGVydHkiLCJyZW1vdmVBdHRyaWJ1dGUiLCJoYW5kbGVDaGFuZ2VQYXNzd29yZCIsImN1cnJlbnRfcGFzc3dvcmQiLCJwYXNzd29yZF9jb25maXJtYXRpb24iLCJpZGVudGljYWwiLCJjb21wYXJlIiwidmFsdWUiLCJpbml0IiwiS1RVdGlsIiwib25ET01Db250ZW50TG9hZGVkIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/extended/js/custom/account/settings/signin-methods.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/assets/extended/js/custom/account/settings/signin-methods.js"]();
/******/ 	
/******/ })()
;