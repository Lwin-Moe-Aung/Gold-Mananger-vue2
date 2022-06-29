<template>
    <v-navigation-drawer
        v-model="drawer"
        app
        color="white"
        mini-variant
        mini-variant-width="110"
    >
        <v-avatar class="d-block text-center mx-auto mt-4" size="40">
            <v-icon color="#704232">far fa-gem</v-icon>
        </v-avatar>
        <v-list flat class="mt-4">
            <v-list-item-group v-model="selected">
                <v-list-item v-for="(item, i) in items" :key="i" active-class="border" :ripple="false">

                        <Link :href="item.link">
                            <v-list-item-content @click="click(i)">
                                <v-icon v-text="item.icon"></v-icon>
                                <v-list-item-subtitle align="center" v-text="item.text" class="mt-3 caption"></v-list-item-subtitle>
                            </v-list-item-content>
                        </Link>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        <div style="position: absolute; bottom: 20px; margin-left: auto; margin-right: auto; left:0; right:0; text-align: center;">
            <v-icon>fas fa-sign-out-alt</v-icon><br><span class="caption">Logout</span>
        </div>
    </v-navigation-drawer>
</template>

<script>
import {mapActions,mapGetters} from "vuex";
import { Link } from '@inertiajs/inertia-vue';
export default {
    components: {
        Link,
    },
    data: () => ({
        selected: 0,
        drawer: null,
        items: [
            {icon: 'fas fa-home', text:'Home',link:route('pos.index')},
            {icon: 'fas fa-save', text:'DailySetup',link:route('pos.daily_setup')},
            {icon: 'fas fa-history', text:'History',link:''},
            {icon: 'fas fa-wallet', text:'Wallet',link:''},
            {icon: 'fas fa-list', text:'List',link:''},
            {icon: 'fas fa-cog', text:'Setting',link:''},
        ],
    }),
    computed: {
        ...mapGetters(['drawer_side_bar']),
    },
    watch: {
        drawer_side_bar (value) {
            this.drawer = value;
        },
    },
    created() {
        // this.unwatch1 = this.$store.watch(
        //     (state, getters) => getters.drawer_side_bar,
        //     (newValue, oldValue) => {
        //         this.drawer = newValue;
        //         // this.changeDrawerSideBar();
        //     },
        // );
    },
    // beforeDestroy() {
    //     this.unwatch1();
    // },
    methods: {
        ...mapActions(["changeDrawerSideBar"]),
        click(i){
            this.selected = integer(i);
        }

    }
}
</script>

<style>
.border {
    margin-left: 8px;
    margin-right: 8px;
    /* background: #704232; */
    background: #ECBD00;
    border-radius: 20px;
    text-decoration: none;
}
.v-list-item-group .v-list-item--active {
    color: white !important;
    /* color: rgb(12, 199, 6) !important; */

}
.theme--light.v-list-item--active .v-list-item__subtitle, .theme--light.v-list-item .v-list-item__action-text {
    color: white !important;
    /* color: rgb(12, 199, 6) !important; */

}
</style>
