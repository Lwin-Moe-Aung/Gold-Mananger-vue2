import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        selectedItem: "",
    },
   
    mutations: {
        
        selectItem: (state, item) => {
            state.selectedItem = item;
        }
    },
    actions: {
       
        selectItem: (context, item) => {
            context.commit('selectItem', item);
        }
    }
});



