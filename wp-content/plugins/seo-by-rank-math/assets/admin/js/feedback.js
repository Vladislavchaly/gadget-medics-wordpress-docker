!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=57)}({4:function(e,t){e.exports=jQuery},57:function(e,t,n){"use strict";n.r(t);var r,o=n(4);(r=n.n(o).a)((function(){var e=r("#rank-math-feedback-form"),t=e.find(".rank-math-feedback-options-wrapper"),n=e.find(".rank-math-feedback-input-wrapper"),o=e.find("form"),a=r("#the-list").find('[data-slug="seo-by-rank-math"] span.deactivate a');a.on("click",(function(t){t.preventDefault(),e.fadeIn()})),e.on("change","input:radio",(function(){n.removeClass("checked"),r(this).parent().toggleClass("checked"),r(this).parent().find(".regular-text").length?t.addClass("selected"):t.removeClass("selected"),o.find(".button-submit").removeAttr("disabled")})),e.on("click",".button-skip",(function(){window.location.href=a.attr("href")})),e.on("click",".button-close",(function(t){t.preventDefault(),e.fadeOut()})),e.on("click",(function(e){"rank-math-feedback-form"===e.target.id&&r(this).find(".button-close").trigger("click")})),o.on("submit",(function(e){e.preventDefault(),o.find(".button-submit").text("").addClass("loading"),r.ajax({url:window.ajaxurl,type:"POST",dataType:"json",data:o.serialize()}).done((function(){window.location.href=a.attr("href")}))}))}))}});