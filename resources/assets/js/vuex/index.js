
import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as mutations from './mutations'
require('../bootstrap');

Vue.use(Vuex);

const state = {
    companies: [],
    vendors: [],
    payments: [],
    withdraws: [],
    orders: [],
    sales: [],
    user: [],
    ajax: true,
    errors: ''
};
const store = new Vuex.Store({
    state,
    actions,
    mutations,
});

if (module.hot) {
    module.hot.accept([
        './actions',
        './mutations'
    ], () => {
        store.hotUpdate({
            actions: require('./actions'),
            mutations: require('./mutations')
        })
    })
}


export default store;