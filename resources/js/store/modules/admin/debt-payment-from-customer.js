import axios from 'axios'
import constant from "../../../constant";

const state = {
    total_credits:null,
    total_debt_payment_amount:null,
    total_debt_payment_amount_for_cal:0,
    checked_voucher_lists:[],
    voucher_lists:[],
};
const getters = {
    total_credits: state => state.total_credits,
    total_debt_payment_amount: state => state.total_debt_payment_amount,
    total_debt_payment_amount_for_cal: state => state.total_debt_payment_amount_for_cal,
    checked_voucher_lists: state => state.checked_voucher_lists,
    voucher_lists: state => state.voucher_lists,
};
const actions = {
    async setTotalCredit({commit}, data){
        await commit("setTotalCredit", data)
    },
    async setTotalDebtPaymentAmount({commit}, data){
        await commit("setTotalDebtPaymentAmount", data)
    },
    async setCheckedVoucherLists({commit}, data){
        let item = state.voucher_lists.find(function(val) {
            return val.id == data.id;
        });
        if(data.status == 'unchecked'){
            await commit("removeFromCheckedVoucherLists", data);
            await commit("setTotalDebtPaymentAmountForCal", parseInt(state.total_debt_payment_amount_for_cal) +parseInt(item.credit_money))
            return;
        }
        if(state.total_debt_payment_amount_for_cal > item.credit_money){
            var debt_payment_amount = item.credit_money;
            await commit("setTotalDebtPaymentAmountForCal", parseInt(state.total_debt_payment_amount_for_cal) -parseInt(item.credit_money))
        }else{
            var debt_payment_amount = state.total_debt_payment_amount_for_cal;
            await commit("setTotalDebtPaymentAmountForCal", 0);
        }
        let checkData = {
            parent_transaction_id: item.id,
            debt_payment_amount: debt_payment_amount,
            remaining_credit: item.credit_money - debt_payment_amount,
            old_paid_money: item.paid_money,
            old_credit_money: item.credit_money,
        };
        await commit("setCheckedVoucherLists", checkData)
    },
    // async removeFromCheckedVoucherLists({commit}, data){
    //     await commit("removeFromCheckedVoucherLists", data)
    // },
    async setVoucherLists({commit}, data){
        await commit("setVoucherLists", data)
    },
    async getCreditDataLists({commit}, data){
        await axios.get(constant.ROUTE_URL_ADMIN+"customer/get-credit-data-lists", { params: { customer_id: data }})
            .then((response) => {
                commit("setVoucherLists", response.data.data);
                commit("setTotalCredit", response.data.total_credits);
        });
    },
};
const mutations = {
    setTotalCredit: (state, data) => ( state.total_credits = data ),
    setTotalDebtPaymentAmount: (state, data) => {
        state.checked_voucher_lists = [];
        state.total_debt_payment_amount = data;
        state.total_debt_payment_amount_for_cal = data;
    },
    setTotalDebtPaymentAmountForCal: (state, data) => {
        state.total_debt_payment_amount_for_cal = data;
    },
    setCheckedVoucherLists: (state, data) => ( state.checked_voucher_lists.push(data) ),
    removeFromCheckedVoucherLists: (state, data) => {
        let item = state.checked_voucher_lists.find(function(val) {
            return val.parent_transaction_id == data.id;
        });
        if(typeof item  !== 'undefined' ){
            state.checked_voucher_lists.splice( state.checked_voucher_lists.indexOf(item),1);
        }
    },
    setVoucherLists: (state, data) => ( state.voucher_lists = data ),
};
export default {
    state,
    getters,
    actions,
    mutations
}
