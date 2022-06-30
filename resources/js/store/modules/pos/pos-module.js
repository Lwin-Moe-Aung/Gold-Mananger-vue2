import axios from 'axios'
import constant from "../../../constant";

const state = {
    selectedItem: "",
    carts:[],
    item_from_cart:false,
    reset_voucher_form:false,
    searched_Items_data:[],
    items:[],
    product_sku: "",
    item_spe: "",
    toast_message: "",
    toast_icon:"",
    customer: "",
    drawer_side_bar:false,
    daily_setup: {},
};
const getters = {
    items: state => state.items,
    selectedItem: state => state.selectedItem,
    product_sku: state => state.product_sku,
    item_spe: state => state.item_spe,
    item_from_cart: state => state.item_from_cart,
    carts: state => state.carts,
    toast_message: state => state.toast_message,
    toast_icon: state => state.toast_icon,
    customer: state => state.customer,
    searched_Items_data: state => state.searched_Items_data,
    reset_voucher_form: state => state.reset_voucher_form,
    drawer_side_bar: state => state.drawer_side_bar,
    daily_setup: state => state.daily_setup,

};
const actions = {
    async searchItem({commit}, data){
        await axios.post(constant.URL+"search", data)
            .then((response) => {
                if(response.data.message !== "newItem"){
                    commit("selectItemReset");
                    commit("setItem", response.data.items);
                    commit("setItemToSearchedItemsData", response.data.items);
                    commit("setToastMessage", response.data.message);
                    commit("setToastIcon", "success");

                }else{
                    Swal.fire({
                        title: 'သေချာပါသလား?',
                        text: "သင်ရှာဖွေနေသောပစ္စည်းမရှိပါ။ အသစ် ဖန်တီးနိုင်ပါသည်။",
                        confirmButtonColor: "#DD6B55",
                        showDenyButton: true,
                        confirmButtonText: `ဖန်တီးမယ်`,
                        denyButtonText: `မဖန်တီးတော့ပါ`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            commit("createNewItem")
                            commit("resetVoucherForm")
                        }
                    });
                }

            });
        commit("setProductSku", data.product_sku);
        commit("resetItemSpe");

    },
    async searchItemByItemId({commit}, item_id){

        await axios.get(constant.URL+"search_by_item_id",   { params: { item_id }})
            .then((response) => {
                if(response.data.message == "success"){
                    let item_lists = response.data.items;
                    let select_Ite = item_lists.find(function(val) {
                        return val.item_sku == item_id;
                    });

                    if(typeof select_Ite  !== 'undefined' ){
                        item_lists.splice(item_lists.indexOf(select_Ite),1)
                        item_lists.unshift(select_Ite)
                        var message = "id -"+item_id +"နဲ့ သူရဲ့ ဆက်စပ့် ပစ္စည်းများ";
                        var icon = "success";
                    }else{
                        var message = "id -"+item_id +"ကရောင်းထွက်ပီးသွားပါပီ။ သူနဲ့ ဆက်စပ့် ပစ္စည်းများသာကြည့်ပါ။";
                        var icon = "warning";
                    }
                    commit("selectItemReset");
                    commit("setItem", item_lists);
                    commit("setItemToSearchedItemsData", item_lists);
                    commit("setToastMessage", message);
                    commit("setToastIcon", icon);
                    commit("resetItemSpe");
                }
        });
    },
    async searchItemByItemSpe({commit}, data){
        await commit("setItemSpe", data)
        if (state.searched_Items_data.length === 0) {
            //do something
        }else{
            const result = state.searched_Items_data.filter(val => val.item_spe == data);
            if(result.length != 0){
                await commit("setItem", result);
            }else{
                Swal.fire({
                    title: 'သေချာပါသလား?',
                    text: "သင်ရှာဖွေနေသောပစ္စည်းမရှိပါ။ အသစ် ဖန်တီးနိုင်ပါသည်။",
                    confirmButtonColor: "#DD6B55",
                    showDenyButton: true,
                    confirmButtonText: `ဖန်တီးမယ်`,
                    denyButtonText: `မဖန်တီးတော့ပါ`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        commit("createNewItem")
                    }
                });
            }

        }
    },
    async selectItem({commit}, data){
        await commit("selectItem", data)

        await commit("setProductSku", data.product_sku)
        await commit("setItemSpe", data.item_spe)
        await commit("resetCustomer")

    },
    async addItem({commit}, data){
        await commit("setItemToCart", data)
    },
    async editItem({commit}, data){
        await commit("editItem", data)
        await commit("setCustomer", data.customer)
        await commit("dailySetup", data.daily_Setup)
        await commit("setProductSku", data.product_sku)

    },
    async editItemFromCart({commit}, data){
        await commit("editItemFromCart", data)
    },
    async removeItem({commit}, item_id){
        await commit("removeItem", item_id)
    },
    async selectItemReset({commit}, data){
        await commit("selectItemReset", data)
    },
    async removeItemFromSearchList({commit}, item_id){
        await commit("removeItemFromSearchList", item_id)
    },
    async setCustomer({commit}, data){
        await commit("setCustomer", data)
    },
    async resetCustomer({commit},data){
        await commit("resetCustomer",data)
    },
    async resetVoucherForm({commit},data){
        await commit("resetVoucherForm",data)
    },
    async renewItemsArray({commit},data){
        await commit("renewItemsArray",data)
    },
    async changeDrawerSideBar({commit},data){
        await commit("changeDrawerSideBar",data)
    },
    async dailySetup({commit},data){
        await commit("dailySetup",data)
    },

};
const mutations = {

    setItem: (state, data) => {
        state.selectedItem = ""
        state.items = []
        state.items = data
    },
    setItemToSearchedItemsData: (state, data) => (
        state.searched_Items_data = data
    ),
    selectItem: (state, item) => (
        state.selectedItem = item,
        state.item_from_cart = false
    ),
    createNewItem: (state, data) => {
        let kyat = parseInt(String(state.item_spe.charAt(0))+String(state.item_spe.charAt(1)));
        let pal = parseInt(String(state.item_spe.charAt(2))+String(state.item_spe.charAt(3)));
        let yway = parseInt(state.item_spe.charAt(4));

        let item = {
            id: "",
            name: "ဖန်တီးထားသော ကုန်ပစ္စည်းအသစ်",
            product_sku: state.product_sku,
            item_spe: state.item_spe,
            image1: "/images/pos/new-default.jpg",
            quality: state.product_sku.length > 3 ? parseInt(String(state.product_sku.charAt(0))+String(state.product_sku.charAt(1))) :
                                                    state.product_sku.charAt(0),
            gold_plus_gem_weight: {kyat:kyat, pal:pal, yway:yway},
            gem_weight: {kyat:0, pal:0, yway:0},
            fee: {kyat:0, pal:3, yway:0},
            fee_for_making: "5000"
        };
        var items = [
            item
        ];
        state.selectedItem = "";
        state.items = [];
        state.items = items;
        state.toast_message = "အခုမှဖန်တီးလိုက်သော ကုန်ပစ္စည်းအသစ်";
        state.toast_icon = "warning";

    },
    setProductSku: (state, data) => {
        state.product_sku = "";
        state.product_sku = data;
    },
    setItemSpe: (state, data) => (
        state.item_spe = data
    ),
    setItemToCart: (state, data) => (
        state.carts.push(data)
    ),
    editItem: (state, data) => (
        state.selectedItem = data,
        state.item_from_cart = true
    ),
    editItemFromCart: (state, data) => {
        let foundIndex = state.carts.findIndex(x => x.id == data.id);
        if(foundIndex > -1) {
            Object.assign(state.carts[foundIndex], data);
        }
    },
    removeItem: (state, item_id) => {

        let item = state.carts.find(function(val) {
            return val.id == item_id;
        });
        if(typeof item  !== 'undefined' ){
            state.carts.splice( state.carts.indexOf(item),1);
        }
        // state.carts.splice( state.carts.findIndex(x => x.id == item_id),1);
        if(state.selectedItem.id == item_id) {
            state.selectedItem = "";
            state.customer = "";
        }
    },
    removeItemFromSearchList: (state, item_id) => {
        if(item_id != ""){
            let item = state.items.find(function(val) {
                return val.id == item_id;
            });
            if(typeof item  !== 'undefined' ){
                state.items.splice( state.items.indexOf(item),1);
            }
            let searched_data = state.searched_Items_data.find(function(val) {
                return val.id == item_id;
            });
            if(typeof searched_data  !== 'undefined' ){
                state.searched_Items_data.splice( state.searched_Items_data.indexOf(searched_data),1);
            }
            // state.items.splice( state.items.findIndex(x => x.id == item_id),1)
        }else{
            state.items.splice(0,1)
        }
    },
    selectItemReset: (state, data) => (
        state.selectedItem = ""
    ),
    setToastMessage: (state, data) => {
        state.toast_message = data
    },
    setToastIcon: (state, data) => {
        state.toast_icon = data
    },
    setCustomer: (state, data) => (
        state.customer = data
    ),
    resetCustomer: (state, data) => (
        state.customer = ""
    ),
    resetItemSpe: (state, data) => (
        state.item_spe = ""
    ),
    resetVoucherForm: (state, data) => (
        state.reset_voucher_form = !state.reset_voucher_form
    ),
    renewItemsArray: (state, data) => {
        state.items = state.searched_Items_data;
        state.selectedItem = "";
        state.item_spe = "";
        state.reset_voucher_form = !state.reset_voucher_form;
    },
    changeDrawerSideBar: (state, data) => (
        state.drawer_side_bar = !state.drawer_side_bar
    ),
    dailySetup: (state, data) => {
        state.daily_setup = {};
        Object.assign( state.daily_setup, data);
    }
};
export default {
    state,
    getters,
    actions,
    mutations
}
