import axios from 'axios'

const state = {
    selectedItem4: "",
    carts6:[],
    h:false,
};
const getters = {
    selectedItem4: state => state.selectedItem4,

};
const actions = {
    async addItem({commit}, data){
        await commit("setItemToCart", data)
    },
};
const mutations = {

    setItem: (state, data) => {
        state.selectedItem = ""
        state.items = []
        state.items = data
    },
};
export default {
    state,
    getters,
    actions,
    mutations
}
