import config from '../config/';
import axios from 'axios';
import Vue from 'vue'
/**
 * Modules vuex
 */
import VueLocalStorage from 'vue-localstorage'
import user from './modules/user-module'
import roles from './modules/roles-module'
import profile from './modules/profile-module'
import users from './modules/users-module'
import orders from './modules/orders-module'
import performers from './modules/performers-module'
import Vuex from 'vuex';


/**
 * Localstorage
 */
Vue.use(VueLocalStorage, {
    name: 'ls',
    createComputed: true //created computed members from your variable declarations
});

Vue.use(Vuex);
const state = {
    list: [],
};

const getters = {
    HTTP(state) {
        let token = Vue.ls.get('token', false);
        // console.log(config);
            return axios.create({
                baseURL: config.baseURI,
                headers: {
                    'Accept': 'application/json',
                    Authorization: `Bearer ${token}`
                }
            });
    },
};
const mutations = {};
const actions = {};
export default new Vuex.Store({
    modules: {
        // users,
        user,
        roles,
        profile,
        orders,
        performers,
    },
    state,
    getters,
    mutations,
    actions
})
