require('./bootstrap');

window.Vue = require('vue').default;

import router from './router';
import App from './layouts/App.vue';

const app = new Vue({
    router,
    el: '#app',
    render: h => h(App)
});
