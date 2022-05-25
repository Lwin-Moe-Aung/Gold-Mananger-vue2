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
                    <v-slide-group active-class="success" show-arrows>
                        <v-slide-item
                            v-for="item in items"
                            :key="item.id"
                            v-slot="{ active, toggle }"
                        >
                            <v-card
                                :color="active ? '#F6EFEF' : 'white'"
                                :class="active ? 'borderme' : 'borderout'"
                                class="d-flex align-center rounded-lg mx-2 mt-1 mb-1"
                                dark
                                height="130"
                                @click="toggle"
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
    mapActions
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
            // items: [],
            model: null,
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
        model(val) {
            if (val == null) {
                this.items = [];
                return;
            }
            axios.get(this.route("pos.search", val))
            .then((response) => {
                // console.log(response);
                this.items = response.data;
            });
        },
        isUpdating (val) {
            if (val) {
            setTimeout(() => (this.isUpdating = false), 3000)
            }
        },
        searchProductSku (val) {
            val && val !== this.selectProductSku && this.querySelections(val)
        },
    },
    methods: {
        ...mapActions(["searchItem", "selectItem"]),

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
        remove (item) {
            this.friends = [];
            // const index = this.friends.indexOf(item.name)
            // if (index >= 0) this.friends.splice(index, 1)
        },
        select(item) {
            // this.$store.dispatch("selectItem", item);
            this.selectItem(item);
        },
        // newItemSelect() {
        //     let fee = {kyat:0, pal:3, yway:0};
        //     let gem_weight = {kyat:0, pal:0, yway:0};
        //     let gold_weight = {
        //         kyat:parseInt(String(this.searchValue.charAt(4))+String(this.searchValue.charAt(5))),
        //         pal:parseInt(String(this.searchValue.charAt(6))+String(this.searchValue.charAt(7))),
        //         yway:this.searchValue.charAt(8),
        //     };
        //     let selectItem = [];
        //     selectItem["id"] = "";
        //     selectItem["name"] = "";
        //     selectItem["product_sku"] = this.searchValue;
        //     selectItem["image1"] = "";
        //     selectItem["quality"] = String(this.searchValue.charAt(0))+String(this.searchValue.charAt(1));
        //     selectItem["fee_for_making"] = "5000";
        //     selectItem["fee"] = fee;
        //     selectItem["gem_weight"] = gem_weight;
        //     selectItem["gold_weight"] = gold_weight;
        //     this.select(selectItem);
        // },
        searchProduct() {
            //regular expression test for "15gr02157"
            // const regex = /(^(0[5-9]|1[0-6]))([a-z]{2})[0-9][0-9](0[0-9]|1[0-5])[0-7]$/g;

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
            // this.$store.dispatch("searchItem", data);
            // this.items = this.$store.state.searchItem;
            this.searchItem(data);

        },
    },
    computed: {
      isActive () {
        return this.searchValue.length === this.length
      },
      ...mapGetters(['items']),
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
