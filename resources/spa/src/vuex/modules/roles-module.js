import router from '../../router/index';

export default {

    namespaced: true,
    state: {
        list: [],
        modules: [],
        rights: [],
    },
    actions: {
        list({state, rootGetters}) {
            return rootGetters.HTTP.get('api/roles').then(
                response => {
                    // console.log('Roles.Get', response.data);
                    let data = response.data;
                    state.list = data.roles;
                    state.modules = data.modules;
                    state.rights = data.rights;
                }
            )
        },
        update({state, rootGetters}, {params, id}) {
            rootGetters.HTTP.put(`api/role/${id}`, params).then(
                response => {
                    console.log('Roles.Update', response);
                    router.push({name: 'role'});
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        create({state, rootGetters}, {params}) {
            rootGetters.HTTP.post(`api/role`, params).then(
                response => {
                    console.log('Roles.Create', response);
                    router.push({name: 'role'});
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        delete({state, rootGetters}, {id}) {
            rootGetters.HTTP.delete(`api/role/${id}`).then(
                response => {
                    console.log('Roles.Delete', response);
                    router.push({name: 'role'});
                }
            ).catch(error => {
                console.log(error.response);
            });
        }
    },
    mutations: {},
    getters: {
        list(state) {
            return state.list;
        },
        modules(state) {
            return state.modules;
        },
        rights(state) {
            return state.rights;
        },
        role: (state) => (id) => {
            return state.list.find((id));
        },
    }
}