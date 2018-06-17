import router from "../../router";

export default {

    namespaced: true,
    state: {
        isLoading: false,
        list: [],
        roles: [],
        filter_roles: [],
    },
    actions: {
        update({state, rootGetters}, {user}) {
            let new_user = Object.assign({}, user);

            if (user.hasOwnProperty('roles')) {
                let roles = new_user.roles.map(elem => elem.id);
                new_user.roles = roles;
            }

            new_user.is_block = !user.active;

            let id = user.id;
            rootGetters.HTTP.put(`api/users/${id}`, {...new_user}).then(
                response => {
                    router.push({name: 'users-view', params: {id}});
                    console.log("Users update", response)
                }
            ).catch(error => {
                console.error('Users loading...', error.response);
            });
        }

        ,
        set_filter_roles({state}, {roles}) {
            state.filter_roles = roles;
        },
        list({state, rootGetters}) {
            return rootGetters.HTTP.get('api/users').then(
                response => {
                    let data = response.data;
                    console.log("Users", data);
                    state.list = data.list;
                    rootGetters.HTTP.get('api/roles').then(
                        roles_response => {
                            let roles_data = roles_response.data;
                            state.roles = roles_data.roles;
                            state.isLoading = true;

                        }
                    ).catch(error => {
                        state.isLoading = false;
                        console.error('Roles loading...', error.response);
                    });

                }
            ).catch(error => {
                state.isLoading = false;
                console.error('Users loading...', error.response);
            });
        },
        create({state, rootGetters}, {user}) {
            let new_user = Object.assign({}, user);
            let roles = new_user.roles.map(elem => elem.id);
            new_user.is_block = !user.active;
            new_user.roles = roles;
            rootGetters.HTTP.post(`api/users`, {...new_user}).then(
                response => {
                    router.push({name: 'users-view'});
                }
            ).catch(error => {
                console.error('Users loading...', error.response);
            });
        },
        get_user({state, rootGetters}, {id}) {
            return rootGetters.HTTP.get(`api/users/${id}`).then(
                response => {
                    return response.data.user
                }
            ).catch(error => {
                if (error.response.status === 500) {
                    router.push({name: 'users-view'})
                }
            });
        },
        remove({state, rootGetters}, {id}) {
            rootGetters.HTTP.delete(`api/users/${id}`).then(
                response => {
                    console.log("Delete user", response);
                    router.push({name: 'users-view'})
                }
            ).catch(error => {
                if (error.response.status === 500) {
                    router.push({name: 'users-view'})
                }
            });
        }

    },
    mutations: {},
    getters: {
        list(state) {
            let users = state.list;
            let roles = state.filter_roles.map(role => role.id);
            if (roles.length > 0) {
                users = users.filter(elem => {
                    let users_roles = elem.roles.map(role => role.role_id);
                    /**
                     * Ищу выбранные роли у каждого пользователя, возвращаю пользователя, если роли найдены
                     */
                    let search_roles = roles.filter(role => users_roles.find(element => element === role));
                    if (search_roles.length > 0) {
                        return elem;
                    }

                });
                return users
            } else {
                return users
            }

        },
        isLoading(state) {
            return state.isLoading;
        },
        roles(state) {

            return state.roles
        }
    }
}