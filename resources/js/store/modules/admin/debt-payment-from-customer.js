import axios from 'axios'
import constant from "../../../constant";

const state = {
    total_credits:null,
    total_debt_payment_amount:null,
    checked_voucher_lists:[],
};
const getters = {
    total_credits: state => state.total_credits,
    total_debt_payment_amount: state => state.total_debt_payment_amount,
    checked_voucher_lists: state => state.checked_voucher_lists,
};
const actions = {
    async setTotalCredit({commit}, data){
        await commit("setTotalCredit", data)
    },
    async setTotalDebtPaymentAmount({commit}, data){
        await commit("setTotalDebtPaymentAmount", data)
    },
    async setCheckedVoucherLists({commit}, data){
        await commit("setCheckedVoucherLists", data)
    },
};
const mutations = {
    setTotalCredit: (state, data) => ( state.total_credits = data ),
    setTotalDebtPaymentAmount: (state, data) => ( state.total_debt_payment_amount = data ),
    setCheckedVoucherLists: (state, data) => ( state.checked_voucher_lists.push(data) ),
};
export default {
    state,
    getters,
    actions,
    mutations
}
