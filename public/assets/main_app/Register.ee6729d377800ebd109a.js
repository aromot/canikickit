(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{401:function(e,t,r){"use strict";r.r(t);var n=r(0),a=r.n(n),o=r(31),u=r(56),i=r.n(u),c=r(62),s=r(86);function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function f(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){p(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function p(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function m(e,t,r,n,a,o,u){try{var i=e[o](u),c=i.value}catch(e){return void r(e)}i.done?t(c):Promise.resolve(c).then(n,a)}function b(e){return function(){var t=this,r=arguments;return new Promise((function(n,a){var o=e.apply(t,r);function u(e){m(o,n,a,u,i,"next",e)}function i(e){m(o,n,a,u,i,"throw",e)}u(void 0)}))}}function y(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){if("undefined"==typeof Symbol||!(Symbol.iterator in Object(e)))return;var r=[],n=!0,a=!1,o=void 0;try{for(var u,i=e[Symbol.iterator]();!(n=(u=i.next()).done)&&(r.push(u.value),!t||r.length!==t);n=!0);}catch(e){a=!0,o=e}finally{try{n||null==i.return||i.return()}finally{if(a)throw o}}return r}(e,t)||function(e,t){if(!e)return;if("string"==typeof e)return v(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return v(e,t)}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function v(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var g=function(){var e=y(Object(n.useState)({username:"Roger",email:"roger@gmail.com",password:"azerty"}),2),t=e[0],r=e[1],u=y(Object(n.useState)({status:"init"}),2),l=u[0],m=u[1];function v(){return(v=b(regeneratorRuntime.mark((function e(r){var n,a;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r.preventDefault(),m({status:"submitting"}),e.prev=2,n=o.a.getRoute("users.register"),e.next=6,i.a.post(n,t);case 6:a=e.sent,console.log(a.data),m({status:"success"}),e.next=14;break;case 11:e.prev=11,e.t0=e.catch(2),console.error(e.t0);case 14:case"end":return e.stop()}}),e,null,[[2,11]])})))).apply(this,arguments)}var g=function(e){r(f(f({},t),p({},e.target.name,e.target.value)))};return a.a.createElement("form",{style:{width:300},onSubmit:function(e){return v.apply(this,arguments)}},"success"===l.status&&a.a.createElement(c.a,{type:"success"},"Inscription réussie"),a.a.createElement(s.a,{name:"username",onChange:g,value:t.username},"User name"),a.a.createElement(s.a,{type:"email",name:"email",onChange:g,value:t.email},"Email"),a.a.createElement(s.a,{type:"password",name:"password",onChange:g,value:t.password},"Password"),a.a.createElement("div",null,a.a.createElement("button",{type:"submit",className:"btn",disabled:"submitting"===l.status},"Inscription")))};t.default=function(){return a.a.createElement(a.a.Fragment,null,a.a.createElement("h1",null,"Registration"),a.a.createElement(g,null))}}}]);