import Vue from 'vue'
import Router from 'vue-router'

import index from '@/components/index'
import navbar from '@/components/elements/navbar'
import main_navbar from '@/components/elements/main_navbar'
import register from '@/components/pages/auth/register'
import login from '@/components/pages/auth/login'
import profile from '@/components/pages/profile/profile'
import orders from './orders'
import performers from '@/components/pages/performers/performers-view'
import performer_profile from '@/components/pages/performers/performer-view'
import customer_profile from '@/components/pages/customers/customer-view'
import app from '@/components/templates/app.vue'
Vue.use(Router);

let router = new Router({
    routes: [
        {
            path: '',
            component: app,
            children: [
                {
                    path: '/',
                    name: 'main',
                    components: {
                        default:index,
                        navbar: main_navbar
                    }
                },

                {
                    path: '/register',
                    name: 'register',
                    components: {
                        default: register,
                        navbar: navbar
                    }
                },


                {
                    path: '/login',
                    name: 'login',
                    components: {
                        default: login,
                        navbar: navbar
                    }
                },

                {
                    path: '/profile',
                    name: 'profile',
                    components: {
                        default: profile,
                        navbar: navbar
                    }
                },
                {
                    path: '/customers/:id',
                    name: 'customer',
                    components: {
                        default: customer_profile,
                        navbar: navbar
                    }
                },
                {
                    path: '/performers',
                    name: 'performers',
                    components: {
                        default: performers,
                        navbar: navbar
                    }
                },

                {
                    path: '/performers/:id',
                    name: 'performer',
                    components: {
                        default: performer_profile,
                        navbar: navbar
                    }
                },

                orders,
            ]
        }
    ]
});


router.beforeEach((to, from, next) => {
    let token = Vue.ls.get('token', false);
    let role = Vue.ls.get('role', false);

    if (to.name === "login" || to.name === "register") {
        if (token) {
            next(false);
        } else {
            next();
        }
    } else {
        if (token) {
            if (role === 'Исполнитель') {
                // to.name === "performers" || to.name === "performer" ||
                if (to.name === "order-create") {
                    next(false);
                } else next();
            }
            else if (role === 'Заказчик') {
                if (to.name === "orders-views") {
                    next(false);
                } else next();
            } else
            next();
        } else {
            Vue.ls.remove('token');
            if (to.name === "performers") next({name: 'login'});
            if (to.name === "orders-views" || to.name === "profile") {
                next(false);
            }else {
                next();
            }
        }

    }
});

export default router