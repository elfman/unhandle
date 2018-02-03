
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

const Identicon = require('identicon.js');
const md5 = require('md5');

$(function ($) {

  $('img[identicon]').each(function(index, elem) {
    const $elem = $(elem);
    const data = new Identicon(md5($elem.attr('identicon')), { size: 300, format: 'svg' }).toString();
    $elem.attr('src', `data:image/svg+xml;base64,${data}`);
    $elem.show();
  });
});
