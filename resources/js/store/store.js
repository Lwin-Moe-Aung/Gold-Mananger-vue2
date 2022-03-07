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
        }
    },
    actions: {
       
        selectItem: (context, item) => {
            context.commit('selectItem', item);
        },

        addItem: (context, item) => {
            context.commit('addItem', item);
        }
    }
});



