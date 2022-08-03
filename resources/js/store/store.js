import Vue from 'vue';
import Vuex from 'vuex';
import PosModule from '../store/modules/pos/pos-module'
import PurchaseReturn from '../store/modules/admin/purchase-return'
import DebtPaymentFromCustomer from '../store/modules/admin/debt-payment-from-customer'

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
        DebtPaymentFromCustomer
    }
});



