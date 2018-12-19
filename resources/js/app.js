
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// import Vue from 'vue'
import VueAxios from 'vue-axios';
import axios from 'axios';
import Vuex from 'vuex';

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('user-follow-button', require('./components/UserFollowButton.vue'));

// Vue.component('question-follow-button',require('./components/QuestionFollowButton.vue'));

// import questionFollowButton from './components/QuestionFollowButton';
Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));



Vue.use(VueAxios, axios);
Vue.use(Vuex);



const app = new Vue({
    el: '#app',

    // render: h => h(questionFollowButton), // 雨下面两行等效，将App.vue 挂载
    // render: h => h(App),
    // render: h => h(App), // 雨下面两行等效，将App.vue 挂载
// template: '<App/>',
//     components: { App },

    // template: '<QuestiosnFollowButton/>',
    // template: '<App/>',
    components:{
        // App,
        // 'question-follow-button': QuestionFollowButton,
        // QuestionFollowButton
        // 'question-follow-button':'question-follow-button'

    }

});

// Vue.use(VueResource);

