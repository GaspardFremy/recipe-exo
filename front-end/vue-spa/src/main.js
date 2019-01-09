import Vue from 'vue'
import Router from 'vue-router'
import App from './App.vue'
import Buefy from 'buefy'
import 'buefy/dist/buefy.css'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Recipe from './components/Recipe.vue'
import Home from './components/Home.vue'
import MenuNav from './components/MenuNav.vue'
import NewRecipe from './components/NewRecipe.vue'
import EditRecipe from './components/EditRecipe.vue'

Vue.use(Router)
Vue.use(Buefy)
Vue.use(VueAxios, axios)
Vue.use(require('vue-moment'));

const router = new Router({
    routes: [
        {
            path: '/home',
            name:'home',
            component: Home
        },
        {
            path: '/recipe/:id',
            name:'recipe',
            component: Recipe,
            props: true
        },
        {
            path: '/menunav',
            name:'menunav',
            component: MenuNav
        },
        {
            path: '/newrecipe',
            name: 'newrecipe',
            component: NewRecipe
        },
        {
            path: '/editrecipe/:id',
            name: 'editrecipe',
            component: EditRecipe,
            props: true
        },
        {
            path : '/category/:category_id',
            name: 'category',
            component: Home,
            props: true
        }
    ],
    mode: 'history'
})


new Vue({
    router,
    el: '#app',
    render: h => h(App)
})
