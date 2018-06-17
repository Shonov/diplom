import config from '../../config/index'
import axios from 'axios'
export default {

    namespaced: true,
    state: {
        status: false,
        token: false,
    },
    actions: {
        token({commit,dispatch}, {token}) {
            commit('token', token)
            dispatch('init',{token})
        },
        init({commit,getters}, {token}) {
            getters.HTTP.post('api/profile').then(r=>{
                console.log(r)
            }).catch(e=>{
                console.error(e)
            })

        }
    },
    mutations: {
        token(state, token) {
            state.token = token;
            state.status = true;
        },
    },
    getters: {
        token(state) {
            return state.token;
        },
        status(state) {
          return state.status;
        },
        HTTP(state) {
            let token = state.token;
            if (token) {
                 return axios.create({
                    baseURL:config.baseURI,
                    headers: {
                        'Accept': 'application/json',
                        Authorization: `Bearer ${token}`
                    }
                });
            }

        }

    }
}