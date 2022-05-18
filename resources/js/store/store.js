import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: true,
    state: {
        selectedItem: "",
        carts:[],
        item_from_cart:false,
    },

    mutations: {
        selectItem: (state, item) => {
            state.selectedItem = item;
            state.item_from_cart = false;
        },
        addItem: (state, item) => {
            state.carts.push(item);
        },
        removeItem: (state, item) => {
            state.carts.splice(state.carts.indexOf(item),1)
        },
        editItem: (state, item) => {
            state.selectedItem = item;
            state.item_from_cart = true;
        },
        editItemFromCart: (state, item) => {
            let foundIndex = state.carts.findIndex(x => x.id == item.id);
            if(foundIndex > -1) {
                Object.assign(state.carts[foundIndex], item);
            }
        }
    },
    actions: {

        selectItem: (context, item) => {
            context.commit('selectItem', item);
        },
        addItem: (context, item) => {
            context.commit('addItem', item);
        },
        removeItem: (context, item) => {
            context.commit('removeItem', item);
        },
        editItem: (context, item) => {
            context.commit('editItem', item);
        },
        editItemFromCart: (context, item) => {
            context.commit('editItemFromCart', item);
        }
    }
});



