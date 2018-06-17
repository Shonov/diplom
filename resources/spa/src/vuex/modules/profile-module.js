export default {

    namespaced: true,
    state: {
        requests:[],
        orders:[]
    },
    actions: {
        requests({state, rootGetters}) {
            return rootGetters.HTTP.get('api/profile/getUserRequests').then(
                response => {
                    state.requests = response.data;
                    // console.log('Requests list', response.data);
                }
            ).catch(error => {
                // console.log('Requests loading...', error.response);
            });
        },
        orders({state, rootGetters}) {
            return rootGetters.HTTP.get('api/profile/getUserOrders').then(
                response => {
                    state.orders = response.data;
                    // console.log('Orders list', response.data);
                }
            ).catch(error => {
                // console.log('Orders loading...', error.response);
            });
        },
        update({state, rootGetters}, {params, id}) {
            return rootGetters.HTTP.put(`api/user/${id}`, params).then(
                response => {
                    console.log('Profile.Update', response);
                    let user = JSON.parse(self.localStorage.getItem('user'));
                    for (let index in params) {
                        if (user.hasOwnProperty(index)) {
                            user[index] = params[index];
                        }}
                   self.localStorage.setItem('user', JSON.stringify(user));
                }
            );
        },
    },
    mutations: {},
    getters: {
        requests(state) {
            return state.requests;
        },
        orders(state) {
            return state.orders;
        },
    }
}