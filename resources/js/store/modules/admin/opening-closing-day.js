import axios from 'axios'
import constant from "../../../constant";


const getDefaultState = () => {
    return {
        global_step: 1,
        daily_setup_amount: null,
        daily_setup_form: {},
        limitation_price: null,
        daily_setup_for_purchase_return_form: {},
        opening_balance: null,
    }
  }
const state = getDefaultState();

const getters = {
    global_step: state => state.global_step,
    daily_setup_form: state => state.daily_setup_form,
    daily_setup_for_purchase_return_form: state => state.daily_setup_for_purchase_return_form,
    opening_balance: state => state.opening_balance,
    daily_setup_amount: state => state.daily_setup_amount,
    limitation_price: state => state.limitation_price,
};
const actions = {
    async setGlobalStep({commit}, data){
        await commit("setGlobalStep", data)
    },
    async reduceGlobalStep({commit}, data){
        await commit("reduceGlobalStep", data)
    },
    async setDailySetupAmount({commit}, data){
        await commit("setDailySetupAmount", data)
    },
    async setLimitationPrice({commit}, data){
        await commit("setLimitationPrice", data)
    },
    async setDailySetupForm({commit}, data){
        await commit("setDailySetupForm", data)
    },
    async setDailySetupPurchaseReturnForm({commit}, data) {
        await commit('setDailySetupPurchaseReturnForm', data)
    },
    async setOpeningBalance({commit}, data) {
        await commit('setOpeningBalance', data)
    },
    async saveData({commit}, data) {
        const formData = {
            daily_setup_form: state.daily_setup_form,
            daily_setup_for_purchase_return_form: state.daily_setup_for_purchase_return_form,
            opening_balance: state.opening_balance,
            limitation_price: state.limitation_price,
        }
        await axios.post(constant.ROUTE_URL_ADMIN+"opening-days/save-data", formData)
            .then((response) => {
                // if(response.status)commit('resetState');
            });
    },
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
    },
    setOpeningBalance: (state, data) => {
        state.opening_balance = data;
    },
    setDailySetupAmount: (state, data) => {
        state.daily_setup_amount = data;
    },
    setLimitationPrice: (state, data) => {
        state.limitation_price = data;
    },
    resetState: (state) => ( Object.assign(state, getDefaultState())),

};
export default {
    state,
    getters,
    actions,
    mutations
}
