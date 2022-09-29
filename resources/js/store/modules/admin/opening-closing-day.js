const state = {
    global_step: 1,
    daily_setup_form: {},
    daily_setup_for_purchase_return_form: {},
    opening_balance: null,

};
const getters = {
    global_step: state => state.global_step,
    daily_setup_form: state => state.daily_setup_form,
    daily_setup_for_purchase_return_form: state => state.daily_setup_for_purchase_return_form,
};
const actions = {
    async setGlobalStep({commit}, data){
        await commit("setGlobalStep", data)
    },

    async reduceGlobalStep({commit}, data){
        await commit("reduceGlobalStep", data)
    },

    async setDailySetupForm({commit}, data){
        await commit("setDailySetupForm", data)
    },

    async setDailySetupPurchaseReturnForm({commit}, data) {
        await commit('setDailySetupPurchaseReturnForm', data)
    }
};
const mutations = {
    setGlobalStep: (state, data) => {
        state.global_step += 1;
    },

    reduceGlobalStep: (state, data) => {
        state.global_step -= 1;
    },

    setDailySetupForm: (state, data) => {
        state.daily_setup_form = {};
        Object.assign( state.daily_setup_form, data);
    },

    setDailySetupPurchaseReturnForm: (state, data) => {
        state.daily_setup_for_purchase_return_form = {};
        Object.assign( state.daily_setup_for_purchase_return_form, data);
    }
};
export default {
    state,
    getters,
    actions,
    mutations
}
