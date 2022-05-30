<template>
    <pos-panel-layout>
        <v-toolbar color="rgba(0,0,0,0)" flat>
            <v-row>
                <v-col cols="12" sm="12">
                    <v-card flat class="rounded-lg mx-2">
                        <v-row>
                            <v-toolbar color="#ECBD00">
                                <!-- autocomplete for product sku -->
                                <v-col cols="2">
                                    <v-autocomplete
                                        v-model="selectProductSku"
                                        :loading="loading"
                                        :items="productsku"
                                        :search-input.sync="searchProductSku"
                                        cache-items
                                        class="mx-4"
                                        flat
                                        hide-no-data
                                        hide-details
                                        label="sku?"
                                        solo-inverted
                                        ></v-autocomplete>
                                </v-col>
                                <!-- end autocomplete for product sku -->

                                <v-col cols="2" sm="2">
                                    <div class="ma-auto" style="max-width: 300px">
                                        <v-otp-input
                                            v-model="searchValue"
                                            :length="length"
                                            type="text"
                                            plain
                                            @finish="searchProduct"
                                        ></v-otp-input>
                                    </div>
                                </v-col>
                                <v-col cols="8" class="my-3">
                                </v-col>
                            </v-toolbar>

                        </v-row>
                    </v-card>
                </v-col>
            </v-row>
        </v-toolbar>

        <v-item-group mandatory class="mt-n1">
            <v-container>
                <v-sheet class="mx-auto" elevation="8" max-width="1090">
                    <v-slide-group
                        active-class="success"
                        show-arrows
                        v-model="model"
                        >
                        <v-slide-item
                            v-for="(item,index) in items"
                            :key="index"
                            v-slot:default="{ active }"
                        >
                            <v-card
                                :color="active ? '#F6EFEF' : 'white'"
                                :class="active ? 'borderme' : 'borderout'"
                                class="d-flex align-center rounded-lg mx-2 mt-1 mb-1"
                                dark
                                height="130"
                                @click="onCardClick(index)"
                                flat
                            >
                                <v-row @click="select(item)">
                                    <v-col cols="12" sm="12">
                                        <v-list-item
                                            two-line
                                            class="text-center"
                                        >
                                            <v-list-item-content>
                                                <div
                                                    align="center"
                                                    justify="center"
                                                >
                                                    <v-img
                                                        :src="item.image1"
                                                        max-height="90"
                                                        max-width="90"
                                                        contain
                                                    ></v-img>
                                                </div>
                                                <v-list-item-subtitle
                                                    :class="
                                                        active
                                                            ? 'brown--text'
                                                            : 'black--text'
                                                    "
                                                    class="caption mt-1"
                                                    >{{
                                                        item.name
                                                    }}</v-list-item-subtitle
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-slide-item>
                    </v-slide-group>
                </v-sheet>
            </v-container>
        </v-item-group>
        <v-toolbar color="#EEEEEE" flat class="toolbar-middle">
            <v-toolbar-title class="mb-7">Customer Profile</v-toolbar-title
            ><v-spacer></v-spacer
            ><span class="mb-7" color="grey">Open Voucher</span>
        </v-toolbar>
        <v-row>
            <Customer />
            <Voucher1 />
            <!-- <Voucher2/> -->
        </v-row>
        <!-- <div class="bg red">hello</div> -->
    </pos-panel-layout>
</template>

<script>
import PosPanelLayout from "../../../Layouts/PosPanelLayout";
import Customer from "./Customer";
import ItemList from "./ItemList";
import Search from "./Search";
import Voucher1 from "./Voucher1";
import Voucher2 from "./Voucher2";
// import { pickBy, throttle } from 'lodash';
import axios from "axios";
import {
        mapGetters,
        mapActions,
        mapState
    } from "vuex";

export default {
    components: {
        PosPanelLayout,
        Customer,
        ItemList,
        Search,
        Voucher1,
        Voucher2,
    },
    data() {
        return {
            model:null,
            searchValue: '',
            length: 5,
            //for product sku auto complete
            loading: false,
            productsku: [],
            searchProductSku: null,
            selectProductSku: null,
            //end for product sku auto complete
        };
    },
    watch: {
        searchProductSku (val) {
            val && val !== this.selectProductSku && this.querySelections(val)
        },
    },
    methods: {
        ...mapActions(["searchItem", "selectItem"]),
        onCardClick(n){
            this.model = n ;
        },
        querySelections (v) {
            this.loading = true
            // Simulated ajax query
            setTimeout(() => {
                axios.get(this.route("pos.productsku_search", v))
                    .then((response) => {
                        this.productsku = response.data.productsku;
                });
                this.loading = false
            }, 500)
        },
        select(item) {
            this.selectItem(item);
        },
        searchProduct() {
            //regular expression test for "15gr02157"
                //-- const regex = /(^(0[5-9]|1[0-6]))([a-z]{2})[0-9][0-9](0[0-9]|1[0-5])[0-7]$/g;

            //regular expression test for "02157"
            const regex = /[0-9][0-9](0[0-9]|1[0-5])[0-7]$/g;

            const matches = regex.exec(this.searchValue);
            if( matches == null){
                Swal.fire(
                    '',
                    'Sku format is something wrong',
                    'fail'
                )
                return false;
            }
            let data = { product_sku: this.searchProductSku, item_spe:this.searchValue}
            this.searchItem(data);
        },
    },
    computed: {
        isActive () {
            return this.searchValue.length === this.length
        },
        ...mapGetters(['items','product_sku', 'item_spe','message']),
    },
    created() {
        this.unwatch1 = this.$store.watch(
            (state, getters) => getters.items,
            (newValue, oldValue) => {
                let item = newValue.find(function(val) {
                    return newValue.indexOf(val) == 0;
                });
                this.select(item);
                this.onCardClick(0);

                // if(item.id == "") var title = "ပစ္စည်းအသစ် ဖန်တီးထားပေးသည်";
                // else var title = "System ထဲကပစ္စည်းများ"
                Toast.fire({
                    icon: 'success',
                    title: this.message
                })

            },
        );
        this.unwatch2 = this.$store.watch(
            (state, getters) => getters.product_sku,
            (newValue, oldValue) => {
                // console.log("hello changin product_sku");
                this.searchProductSku = newValue,
                this.selectProductSku = newValue
            },
        );
        this.unwatch3 = this.$store.watch(
            (state, getters) => getters.item_spe,
            (newValue, oldValue) => {
                this.searchValue = newValue
            },
        );
    },
    beforeDestroy() {
        this.unwatch1();
        this.unwatch2();
        this.unwatch3();
    },
};
</script>

<style>
.v-card.borderme {
    border: 2px solid #704232 !important;
}
.v-card.borderout {
    border: 1px solid #bcaaa4 !important;
}
.voucher-row {
    margin-bottom: -22px;
}
.voucher-row1 {
    margin-bottom: -37px;
}
.toolbar-middle {
    height: 40px !important;
}
/* .v-toolbar__content{
  height: 31px !important;
} */
.v-timeline {
    padding-top: 0 !important;
}
.v-toolbar__content {
    height: 71px !important;
}
</style>
