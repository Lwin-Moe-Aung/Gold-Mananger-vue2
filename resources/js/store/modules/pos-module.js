import axios from 'axios'
import constant from "../../constant";

const state = {
    selectedItem: "",
    carts:[],
    item_from_cart:false,
    items:[],
};
const getters = {
    items: state => state.items,
    selectedItem: state => state.selectedItem,
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
                        state.items = [];
                        let fee = {kyat:0, pal:3, yway:0};
                        let gem_weight = {kyat:0, pal:0, yway:0};
                        let gold_weight = {
                            kyat: parseInt(String(data.item_spe.charAt(4))+String(data.item_spe.charAt(5))),
                            pal: parseInt(String(data.item_spe.charAt(6))+String(data.item_spe.charAt(7))),
                            yway: data.item_spe.charAt(8),
                        };
                        let selectItem = [];
                        selectItem["id"] = "";
                        selectItem["name"] = "";
                        selectItem["product_sku"] = data.product_sku+data.item_spe;
                        selectItem["image1"] = "";
                        selectItem["quality"] = String(data.product_sku.charAt(0))+String(data.product_sku.charAt(1));
                        selectItem["fee_for_making"] = "5000";
                        selectItem["fee"] = fee;
                        selectItem["gem_weight"] = gem_weight;
                        selectItem["gold_weight"] = gold_weight;

                        // state.items = selectItem;
                        commit("setItem", selectItem);
                }

            });
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
    )
};
export default {
    state,
    getters,
    actions,
    mutations
}
