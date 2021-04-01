import Vue from 'vue'
import VueRouter from 'vue-router'
import ViewUI from 'view-design'
import App from './App.vue'
import {routes} from './router/index'
import 'view-design/dist/styles/iview.css'

Vue.use(VueRouter)
Vue.use(ViewUI)

const router = new VueRouter({
    mode: 'history',
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.title) {
        document.title = to.meta.title
    }
    next()
})

new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>'
})
