import axios from 'axios'
import constant from "../../../constant";

const getDefaultState = () => {
    return {
        total_credits:null,
        total_debt_payment_amount:null,
        total_debt_payment_amount_for_cal:0,
        checked_voucher_lists:[],
        voucher_lists:[],
    }
  }
const state = getDefaultState();

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
            let item = state.checked_voucher_lists.find(function(val) {
                return val.parent_transaction_id == data.id;
            });
            await commit("setTotalDebtPaymentAmountForCal", parseInt(state.total_debt_payment_amount_for_cal) +parseInt(item.debt_payment_amount));
            await commit("removeFromCheckedVoucherLists", item);
            return;
        }
        if(state.total_debt_payment_amount_for_cal > parseInt(item.credit_money)){
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
    async setVoucherLists({commit}, data){
        await commit("setVoucherLists", data)
    },
    async getCreditDataLists({commit}, data){
        await commit('resetState');
        await axios.get(constant.ROUTE_URL_ADMIN+ data.url, { params: { contact_id: data.contact_id }})
            .then((response) => {
                commit("setVoucherLists", response.data.data);
                commit("setTotalCredit", response.data.total_credits);
        });
    },
    async repairingCheckedVoucherListsForDatabase({commit}, data){
        await commit("repairingCheckedVoucherListsForDatabase");
    },
    resetCartState ({ commit }) {
        commit('resetState')
    },
};
const mutations = {
    resetState: (state) => ( Object.assign(state, getDefaultState())),
    setTotalCredit: (state, data) => ( state.total_credits = data ),
    setTotalDebtPaymentAmount: (state, data) => {
        console.log(data);
        state.checked_voucher_lists = [];
        state.total_debt_payment_amount = data;
        state.total_debt_payment_amount_for_cal = data == null ? 0 : data;
    },
    setTotalDebtPaymentAmountForCal: (state, data) => {
        state.total_debt_payment_amount_for_cal = data;
    },
    setCheckedVoucherLists: (state, data) => ( state.checked_voucher_lists.push(data) ),

    removeFromCheckedVoucherLists: (state, data) => {
        state.checked_voucher_lists.splice( state.checked_voucher_lists.indexOf(data),1);
        state.checked_voucher_lists.forEach(element =>
            state.total_debt_payment_amount_for_cal = parseInt(state.total_debt_payment_amount_for_cal)
            + parseInt(element.debt_payment_amount)
        );
        state.checked_voucher_lists.forEach((element,index) => {
                if(state.total_debt_payment_amount_for_cal > parseInt(element.old_credit_money)){
                    var debt_payment_amount = parseInt(element.old_credit_money);
                    state.total_debt_payment_amount_for_cal = parseInt(state.total_debt_payment_amount_for_cal) -parseInt(element.old_credit_money);
                }else{
                    var debt_payment_amount = parseInt(state.total_debt_payment_amount_for_cal);
                    state.total_debt_payment_amount_for_cal = 0;
                }
                let checkData = {
                    parent_transaction_id: element.parent_transaction_id,
                    debt_payment_amount: debt_payment_amount,
                    remaining_credit: element.old_credit_money - debt_payment_amount,
                    old_paid_money: element.old_paid_money,
                    old_credit_money: element.old_credit_money,
                }
                Object.assign(state.checked_voucher_lists[index], checkData);
            }
        );
    },
    repairingCheckedVoucherListsForDatabase: (state) => {
        let yFilter = state.checked_voucher_lists.map(itemY => { return itemY.parent_transaction_id; });

        // Use filter and "not" includes to filter the full dataset by the filter dataset's val.
        let filteredX = state.voucher_lists.filter(itemX => !yFilter.includes(itemX.id));

        filteredX.forEach((element) => {
                let checkData = {
                    parent_transaction_id: element.id,
                    debt_payment_amount: 0,
                    remaining_credit: element.credit_money,
                    old_paid_money: element.paid_money,
                    old_credit_money: element.credit_money,
                };
                state.checked_voucher_lists.push(checkData)
            }
        );

    },
    setVoucherLists: (state, data) => ( state.voucher_lists = data ),
};
// export function resetState() {
//     store.replaceState(initialStateCopy)
// };
export default {
    state,
    getters,
    actions,
    mutations,
}
