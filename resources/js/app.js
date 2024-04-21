/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

window.$ = require('jquery');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Components
Vue.component('multi-select', require('./components/MultiSelectComponent.vue').default);
Vue.component('heading', require('./components/Heading.vue').default);
Vue.component('sub-heading', require('./components/SubHeading.vue').default);
Vue.component('text-input', require('./components/TextInput.vue').default);
Vue.component('xbutton', require('./components/Button.vue').default);
Vue.component('select-input', require('./components/SelectInput.vue').default);

// Pages
Vue.component('addon-pack-template-generator', require('./pages/AddonPackTemplateGenerator.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
