import axios from 'axios'
import constant from "../../constant";

const state = {
    selectedItem: "",
    carts:[],
    item_from_cart:false,
    items:[],
    product_sku: "",
    item_spe: "",
};
const getters = {
    items: state => state.items,
    selectedItem: state => state.selectedItem,
    product_sku: state => state.product_sku,
    item_spe: state => state.item_spe,
    item_from_cart: state => state.item_from_cart,
    carts: state => state.carts,


};
const actions = {
    async searchItem({commit}, data){
        await axios.post(constant.URL+"search", data)
                .then((response) => {
                    if(response.data.message == "existing"){
                        // state.items = [];
                        commit("setItem", response.data.items);
                        // state.items = response.data.items;

                    }else{
                        console.log(data.item_spe);
                        let fee = {kyat:0, pal:3, yway:0};
                        let gem_weight = {kyat:0, pal:0, yway:0};
                        let gold_weight = {
                            kyat: parseInt(String(data.item_spe.charAt(0))+String(data.item_spe.charAt(1))),
                            pal: parseInt(String(data.item_spe.charAt(2))+String(data.item_spe.charAt(3))),
                            yway: data.item_spe.charAt(4),
                        };
                        let item = {
                            id: "",
                            name: "ကုန်ပစ္စည်းအသစ် ဖန်တီးထားသော",
                            product_sku: data.product_sku,
                            image1: "/images/pos/new-default.jpg",
                            quality: parseInt(String(data.product_sku.charAt(0))+String(data.product_sku.charAt(1))),
                            gold_weight: gold_weight,
                            gem_weight: gem_weight,
                            fee: fee,
                            fee_for_making: "5000"

                        };
                        let seleItem = [
                            item
                        ];
                        commit("setItem", seleItem);
                }

            });

        commit("setProductSku", data.product_sku);
        commit("setItemSpe", data.item_spe);

    },
    async searchItemByItemId({commit}, item_id){

        await axios.get(constant.URL+"search_by_item_id",   { params: { item_id }})
            .then((response) => {
                if(response.data.message == "success"){
                    let item_lists = response.data.items;
                    let select_Ite = item_lists.find(function(val) {
                        return val.item_sku == item_id;
                    });
                    item_lists.splice(item_lists.indexOf(select_Ite),1)
                    item_lists.unshift(select_Ite)
                    commit("setItem", item_lists);
                    commit("setProductSku", select_Ite.product_sku);
                    let kyat = String(select_Ite.gold_weight.kyat).length == 1 ? '0'+select_Ite.gold_weight.kyat : select_Ite.gold_weight.kyat;
                    let pal = String(select_Ite.gold_weight.pal).length == 1 ? '0'+select_Ite.gold_weight.pal : select_Ite.gold_weight.pal;

                    let item_spe = String(kyat)+String(pal)+String(select_Ite.gold_weight.yway)
                    commit("setItemSpe", item_spe);
                }
        });
    },
    async selectItem({commit}, data){
        await commit("selectItem", data)
    },
    async addItem({commit}, data){
        await commit("setItemToCart", data)
    },
    async editItem({commit}, data){
        await commit("editItem", data)
    },
    async editItemFromCart({commit}, data){
        await commit("editItemFromCart", data)
    },
    async removeItem({commit}, data){
        await commit("removeItem", data)
    },
    async selectItemReset({commit}, data){
        await commit("selectItemReset", data)
    },

};
const mutations = {

    setItem: (state, data) => (
        state.items = [],
        state.items = data
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
    removeItem: (state, data) => (
        state.carts.splice(state.carts.indexOf(data),1)
    ),
    selectItemReset: (state, data) => (
        state.selectedItem = ""
    ),
};
export default {
    state,
    getters,
    actions,
    mutations
}
