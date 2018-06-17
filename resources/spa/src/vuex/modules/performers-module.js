import router from "../../router";

export default {

    namespaced: true,
    state: {
        list: [],
        categories: [],
    },
    actions: {
        list({state, rootGetters}) {
            return rootGetters.HTTP.get('api/performers').then(
                response => {
                    state.list = response.data;
                    // console.log('performers', state.list);
                }
            ).catch(error => {
                console.log('Performers loading...', error.response);
            });
        },
        allWorkCategories({state, rootGetters}){
            state.categories = [];
            return rootGetters.HTTP.get('api/categories').then(
                response => {
                    state.categories = response.data;
                    // console.log('Work caterories', state.categories);
                }
            ).catch(error => {
                console.log('Work caterories...', error.response);
            });
        },
        getPerformer({state, rootGetters}, {id}) {
            return rootGetters.HTTP.get(`api/performers/${id}`).then(
                response => {
                    console.log(response.data);
                    return response.data;
                }
            ).catch(error => {
                if (error.response.status === 500) {
                    router.push({name: 'performers-view'})
                }
            });
        },
    },
    mutations: {},
    getters: {
        list(state) {
            return state.list;
        },
        categories(state) {
            return state.categories;
        },
    }
}