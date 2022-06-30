import Vue from 'vue';
import Vuex from 'vuex';
import PosModule from '../store/modules/pos/pos-module'
import PurchaseReturn from '../store/modules/admin/purchase-return'

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
        PosModule,
        PurchaseReturn
    }
});



