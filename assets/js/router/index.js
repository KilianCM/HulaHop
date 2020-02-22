import Router from 'vue-router'

import HomePage from "../pages/home/HomePage";

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'HomePage',
            component: HomePage
        },
    ]
})