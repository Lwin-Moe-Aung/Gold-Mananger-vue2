import axios from 'axios'
import constant from "../../constant";

const state = {
    selectedItem: "",
    carts:[],
    item_from_cart:false,
    searched_Items_data:[],
    items:[],
    product_sku: "",
    item_spe: "",
    toast_message: "",
    toast_icon:"",
    customer: "",
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
};
const actions = {
    async searchItem({commit}, data){
        await axios.post(constant.URL+"search", data)
                .then((response) => {
                    if(response.data.message !== "newItem"){
                        var items = response.data.items;
                        var message = response.data.message;
                        var icon = "success"

                    }else{
                        alert("create new Item?");
                        // let fee = {kyat:0, pal:3, yway:0};
                        // let gem_weight = {kyat:0, pal:0, yway:0};

                        // var kyat = 1;
                        // var pal = 0;
                        // var yway = 0;
                        // if(data.item_spe !== null){
                        //     kyat = parseInt(String(data.item_spe.charAt(0))+String(data.item_spe.charAt(1)))
                        //     pal = parseInt(String(data.item_spe.charAt(2))+String(data.item_spe.charAt(3)))
                        //     yway = data.item_spe.charAt(4)
                        // }
                        // let gold_weight = {
                        //     kyat: kyat,
                        //     pal: pal,
                        //     yway: yway,
                        // };

                        // let item = {
                        //     id: "",
                        //     name: "ဖန်တီးထားသော ကုန်ပစ္စည်းအသစ်",
                        //     product_sku: data.product_sku,
                        //     item_spe: data.item_spe !== null ? data.item_spe : '01000',
                        //     image1: "/images/pos/new-default.jpg",
                        //     quality: parseInt(String(data.product_sku.charAt(0))+String(data.product_sku.charAt(1))),
                        //     gold_weight: gold_weight,
                        //     gem_weight: gem_weight,
                        //     fee: fee,
                        //     fee_for_making: "5000"

                        // };
                        // var items = [
                        //     item
                        // ];
                        // var message = "အခုမှဖန်တီးလိုက်သော ကုန်ပစ္စည်းအသစ်";
                        // var icon = "warning";
                    }
                    commit("setItem", items);
                    commit("setItemToSearchedItemsData", items);
                    commit("setToastMessage", message);
                    commit("setToastIcon", icon);

                });
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

                    commit("setItem", item_lists);
                    commit("setToastMessage", message);
                    commit("setToastIcon", icon);

                }
        });
    },
    async searchItemByItemSpe({commit}, data){
        if (state.searched_Items_data.length === 0) {
            //do something
        }else{
            const result = state.searched_Items_data.filter(val => val.item_spe == data);
            commit("setItem", result);
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

};
const mutations = {

    setItem: (state, data) => (
        state.items = data
    ),
    setItemToSearchedItemsData: (state, data) => (
        state.searched_Items_data = data
    ),
    selectItem: (state, item) => (
        state.selectedItem = item,
        state.item_from_cart = false
    ),
    setProductSku: (state, data) => (
        state.product_sku = data
    ),
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
    )
};
export default {
    state,
    getters,
    actions,
    mutations
}
