import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter)

import Home from './pages/Home'
import PostPage from './pages/PostPage'
import PageNotFound from './pages/PageNotFound.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/posts/:slug',
            name: 'post',
            component: PostPage
        },
        {
            path: '*',
            name: '404-page',
            component: PageNotFound
        }
    ]
})

export default router