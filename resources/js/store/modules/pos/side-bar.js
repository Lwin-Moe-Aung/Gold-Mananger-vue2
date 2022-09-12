
const state = {
    selected: 0,
    drawer_side_bar: false,
};
const getters = {
    selected: state => state.selected,
    drawer_side_bar: state => state.drawer_side_bar,
};
const actions = {
    async setSelected({commit}, data){
        await commit("setSelected", data)
    },
    async changeDrawerSideBar({commit},data){
        await commit("changeDrawerSideBar",data)
    },
};
const mutations = {
    setSelected: (state, data) => {
        state.selected = data
    },
    changeDrawerSideBar: (state, data) => (
        state.drawer_side_bar = !state.drawer_side_bar
    ),
};
export default {
    state,
    getters,
    actions,
    mutations
}
