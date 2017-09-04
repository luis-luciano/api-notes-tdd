Vue.component('select-category',require('./components/select-category.vue'));

Vue.component('note-row', require('./components/note-row.vue'));

import App from './components/app.vue';

const vm= new Vue({
    el: '#app',
    components: {
        app: App
    }
});