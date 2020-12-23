/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import Vue from "vue";
import vuetify from "./plugins/Vuetify";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import App from "./views/App";

import NotFound from "./views/NotFound";

import SuperheroIndex from "./views/SuperheroIndex";
import SuperheroEdit from "./views/SuperheroEdit";
import SuperheroCreate from "./views/SuperheroCreate";
import SuperheroShow from "./views/SuperheroShow";
import SuperheroFavorites from "./views/SuperheroFavorites";
import SuperheroCompare from "./views/SuperheroCompare";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: SuperheroIndex
        },

        {
            path: "/superheroes",
            name: "superhero.index",
            component: SuperheroIndex
        },
        {
            path: "/superhero/:id",
            name: "superhero.show",
            component: SuperheroShow
        },
        {
            path: "/superhero/:id/edit",
            name: "superhero.edit",
            component: SuperheroEdit
        },
        {
            path: "/create-superhero",
            name: "superhero.create",
            component: SuperheroCreate
        },
        {
            path: "/favorite-superheroes",
            name: "superhero.favorites",
            component: SuperheroFavorites
        },
        {
            path: "/compare-superheroes",
            name: "superhero.compare",
            component: SuperheroCompare
        },
        { path: "/404", name: "404", component: NotFound },
        { path: "*", redirect: "/404" }
    ]
});

const app = new Vue({
    el: "#app",
    components: { App },
    router,
    vuetify
});

// window.Vue = require('vue');

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // const files = require.context('./', true, /\.vue$/i)
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// const app = new Vue({
//     el: '#app',
//     components: { App },
//     router,
// });
