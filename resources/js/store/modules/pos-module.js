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
    async selectItem({commit}, item){

        commit("selectItem", item)
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
};
export default {
    state,
    getters,
    actions,
    mutations
}
