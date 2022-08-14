import Vue from 'vue';
import Vuex from 'vuex';
import PosModule from '../store/modules/pos/pos-module'
import PurchaseReturn from '../store/modules/admin/purchase-return'
import DebtPayment from './modules/admin/debt-payment'

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
        PurchaseReturn,
        DebtPayment
    }
});



