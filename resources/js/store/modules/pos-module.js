import axios from 'axios'
import constant from "../../constant";

const state = {
    selectedItem: "",
    carts:[],
    item_from_cart:false,
    items:[],
    product_sku: "",
    item_spe: "",
    message: "",
};
const getters = {
    items: state => state.items,
    selectedItem: state => state.selectedItem,
    product_sku: state => state.product_sku,
    item_spe: state => state.item_spe,
    item_from_cart: state => state.item_from_cart,
    carts: state => state.carts,
    message: state => state.message,
};
const actions = {
    async searchItem({commit}, data){
        await axios.post(constant.URL+"search", data)
                .then((response) => {
                    if(response.data.message !== "newItem"){
                        commit("setItem", response.data.items);
                        commit("setmessage", response.data.message);
                    }else{
                        let fee = {kyat:0, pal:3, yway:0};
                        let gem_weight = {kyat:0, pal:0, yway:0};

                        var kyat = 1;
                        var pal = 0;
                        var yway = 0;
                        if(data.item_spe !== null){
                            kyat = parseInt(String(data.item_spe.charAt(0))+String(data.item_spe.charAt(1)))
                            pal = parseInt(String(data.item_spe.charAt(2))+String(data.item_spe.charAt(3)))
                            yway = data.item_spe.charAt(4)
                        }
                        let gold_weight = {
                            kyat: kyat,
                            pal: pal,
                            yway: yway,
                        };

                        let item = {
                            id: "",
                            name: "ဖန်တီးထားသော ကုန်ပစ္စည်းအသစ်",
                            product_sku: data.product_sku,
                            item_spe: data.item_spe !== null ? data.item_spe : '01000',
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
                        let message = "အခုမှဖန်တီးလိုက်သော ကုန်ပစ္စည်းအသစ်";
                        commit("setItem", seleItem);
                        commit("setmessage", message);
                }

            });
        // commit("setProductSku", data.product_sku);
        // commit("setItemSpe", data.item_spe);

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
                    // commit("setProductSku", select_Ite.product_sku);
                    // let kyat = String(select_Ite.gold_weight.kyat).length == 1 ? '0'+select_Ite.gold_weight.kyat : select_Ite.gold_weight.kyat;
                    // let pal = String(select_Ite.gold_weight.pal).length == 1 ? '0'+select_Ite.gold_weight.pal : select_Ite.gold_weight.pal;

                    // let item_spe = String(kyat)+String(pal)+String(select_Ite.gold_weight.yway)
                    // commit("setItemSpe", item_spe);
                    let message = "id -"+item_id +"နဲ့ ဆက်စပ့် ပစ္စည်းများ";
                    commit("setmessage", message);
                }
        });
    },
    async selectItem({commit}, data){
        await commit("selectItem", data)

        await commit("setProductSku", data.product_sku)
        await commit("setItemSpe", data.item_spe)
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
    async removeItem({commit}, item_id){
        await commit("removeItem", item_id)
    },
    async selectItemReset({commit}, data){
        await commit("selectItemReset", data)
    },
    async removeItemFromSearchList({commit}, item_id){
        await commit("removeItemFromSearchList", item_id)
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
    removeItem: (state, item_id) => (
        state.carts.splice( state.carts.findIndex(x => x.id == item_id),1)
    ),
    removeItemFromSearchList: (state, item_id) => {
        if(item_id != ""){
            state.items.splice( state.items.findIndex(x => x.id == item_id),1)
        }else{
            state.items.splice(0,1)
        }
    },
    selectItemReset: (state, data) => (
        state.selectedItem = ""
    ),
    setmessage: (state, data) => (
        state.message = data
    ),
};
export default {
    state,
    getters,
    actions,
    mutations
}
