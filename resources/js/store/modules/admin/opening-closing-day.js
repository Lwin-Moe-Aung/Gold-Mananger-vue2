const state = {
    global_step: 1,
};
const getters = {
    global_step: state => state.global_step,
};
const actions = {
    async setGlobalStep({commit}, data){
        await commit("setGlobalStep", data)
    },

    async reduceGlobalStep({commit}, data){
        await commit("reduceGlobalStep", data)
    },
};
const mutations = {
    setGlobalStep: (state, data) => {
        state.global_step += 1;
    },

    reduceGlobalStep: (state, data) => {
        state.global_step -= 1;
    },
};
export default {
    state,
    getters,
    actions,
    mutations
}
