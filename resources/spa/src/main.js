// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router/index'
import BootstrapVue from 'bootstrap-vue'

import store from './vuex/'
import config from './config'
import axios from 'axios'

import user_mixin from './mixins/user'
import router_mixin from './mixins/router'

import * as VueGoogleMaps from 'vue2-google-maps'
import VueLocalStorage from "vue-localstorage/src/VueLocalStorage";

import VeeValidate, { Validator } from 'vee-validate';
import ru from 'vee-validate/dist/locale/ru';

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyAkDGMQ914Fyg_C4EeqEQv0N0o1fVIEC6E',
        libraries: 'places,drawing,visualization'
     },
    options:{

    }
});
import Multiselect from 'vue-multiselect'

Vue.component('multiselect', Multiselect);

Vue.use(BootstrapVue);
Vue.use(VueLocalStorage);

Vue.use(VeeValidate, {
    errorBagName: 'errors', // change if property conflicts.
    fieldsBagName: 'inputs ', //Default is fields}
    locale: Validator.localize('ru', ru),
});

Vue.config.productionTip = false;

let global_mixin = {
    install(Vue, options) {
        Vue.mixin({
            watch: {},
            data() {
                return {
                    init_config: config,
                }
            },
            computed: {},
            mounted() {},
            methods: {
                _http() {
                    if (this.token) {
                        let http = axios.create({
                            baseURL: this.init_config.baseURI,
                                headers: {
                                    Application: 'application/json',
                                    Authorization: `Bearer ${this.token}`
                                }
                        })
                    }
                },
            }
        })
    }
};

Vue.use(global_mixin);
Vue.use(router_mixin);
Vue.use(user_mixin);

new Vue({
  el: '#app',
  router,
  store,
  components: {App},
  template: '<App/>'
});
