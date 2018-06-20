import router from "../../router";
import axios from "axios";

export default {

    namespaced: true,
    state: {
        list: [],
        budget_list: [],
    },
    actions: {
        list({state, rootGetters}) {
            return rootGetters.HTTP.get('api/orders').then(
                response => {
                    delete(response.data['count']);
                    state.list = response.data.data;
                    // console.log('Orders list', response);
                }
            ).catch(error => {
                // console.log('Orders loading...', error.response);
            });
        },
        update({state, rootGetters}, {params, id}) {
            return rootGetters.HTTP.put(`api/orders/${id}`, params).then(
                response => {
                    console.log('Orders.Update', response);
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        create({state, rootGetters}, {params}) {
            console.log('params', params);
            rootGetters.HTTP.post(`api/orders`, params).then(
                response => {
                    // console.log('Orders.Create', response);
                    router.push({name: 'orders-views'});
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        delete({state, rootGetters}, {id}) {
            rootGetters.HTTP.delete(`api/orders/${id}`).then(
                response => {
                    // console.log('Orders.Delete', response);
                    router.push({name: 'orders-view'});
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        changeStatus({state, rootGetters}, {params, id}) {
            rootGetters.HTTP.put(`api/orders/${id}`, params).then(
                response => {
                    // console.log('Orders.ChangeStatus', response);
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        getOrder({state, rootGetters}, {id}) {
            return rootGetters.HTTP.get(`api/orders/${id}`).then(
                response => {
                    return response.data;
                }
            ).catch(error => {
                if (error.response.status === 500) {
                    router.push({name: 'orders-views'})
                }
            });
        },
        getStatuses({state, rootGetters}) {
            return rootGetters.HTTP.get(`api/orders/statuses`).then(
                response => {
                    return response.data;
                }
            );
        },
        getBudget({state, rootGetters}) {
            return rootGetters.HTTP.get('api/getBudget').then(
                response => {
                    state.budget_list = response.data;
                    return response.data;
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        uploadImages({state, rootGetters}) {
            return axios.post(`api/orders/upload`, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'multipart/form-data',
                }
            }).then(
                response => {
                    console.log("Upload files", response.data);
                    return response.data;
                }
            ).catch(error => {
                console.log(error.response);
            });
        },
        createRequest({state, rootGetters}, {params}) {
            rootGetters.HTTP.post(`/api/orders/createOrderRequest`, {params}).then(
                response => {
                    let a = [];
                    if (JSON.parse(this.$ls.get('list')) === null)
                        a = [];
                    else
                        a = JSON.parse(this.$ls.get('list'));
                    a.push(JSON.parse(this.$route.params.id));
                    this.list = a;
                    console.log(a);
                    this.$ls.set('list', JSON.stringify(a));
                    this.showModal();
                });
        },
        deleteRequest({state, rootGetters}, {id}) {
            return rootGetters.HTTP.delete(`/api/orders/request/${id}`).then(
                response => {
                    console.log(response);

                    // let a = this.$ls.get('list');
                    // delete a[this.$route.params.id];
                    // this.$ls.set('list', [] = response.data.order_id);
                    // this.showModal();
                });
        },
        getCustomer({state, rootGetters}, {id}) {
            return rootGetters.HTTP.get(`api/customers/${id}`).then(
                response => {
                    return response.data;
                }
            ).catch(error => {
                if (error.response.status === 500) {
                    router.push({name: 'orders-views'})
                }
            });
        },
    },
    mutations: {},
    getters: {
        list(state) {
            return state.list;
        },
        budget_list(state) {
            return state.budget_list;
        },
    }
}
