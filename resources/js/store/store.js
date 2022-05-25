import Vue from 'vue';
import Vuex from 'vuex';
import PosModule from '../store/modules/pos-module'
Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: true,
    state: {
    },
    mutations: {
    },
    actions: {
    },
    modules: {
        PosModule
    }
});



