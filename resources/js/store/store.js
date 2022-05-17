import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    strict: true,
    state: {
        selectedItem: "",
        carts:[],
    },

    mutations: {

        selectItem: (state, item) => {
            state.selectedItem = item;
        },
        addItem: (state, item) => {
            state.carts.push(item);
        },
        removeItem: (state, item) => {
            state.carts.splice(state.carts.indexOf(item),1)
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
        }
    }
});



