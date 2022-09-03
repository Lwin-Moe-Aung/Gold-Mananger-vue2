<template>
    <v-toolbar color="#ECBD00" flat >
        <!-- <v-btn
          icon
          dark
          class="d-lg-none d-sm-flex black--text"
          @click="changeDrawerSideBar()"
        >
           <v-icon v-text="'fas fa-bars'"></v-icon>
        </v-btn> -->
        <v-app-bar-nav-icon
            class="d-lg-none d-sm-flex black--text"
            @click="changeDrawerSideBar()"
            >
        </v-app-bar-nav-icon>
        <v-spacer class="d-lg-none d-xl-flex black--text"></v-spacer>

        <v-flex xs4 md2 sm2 lg2 class="ml-8 text-left">
            <v-autocomplete
                v-model="selectProductSku"
                :loading="loading"
                :items="productsku"
                :search-input.sync="searchProductSku"
                @change="onChange()"
                cache-items
                class="mx-4"
                flat
                hide-no-data
                hide-details
                label="sku?"
                solo-inverted
                ></v-autocomplete>
        </v-flex>
        <v-flex xs3 md3 sm3 lg2 class="mt-4">

                <!-- <v-otp-input
                    v-model="searchValue"
                    :length="length"
                    type="text"
                    plain
                    @finish="textFieldChange"
                ></v-otp-input> -->

                <v-text-field
                    v-model="searchValue"
                    label="အလေးချိန်"
                    placeholder="အလေးချိန်"
                    outlined
                    solo
                    dense
                    counter
                    maxlength="5"
                    @input="textFieldChange"
                ></v-text-field>
        </v-flex>
    </v-toolbar>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import axios from "axios";

    export default {
        name: 'TopSearchBar',
        data: () => ({
            searchValue: '',
            length: 5,
            //for product sku auto complete
            loading: false,
            productsku: [],
            searchProductSku: null,
            selectProductSku: null,
            //end for product sku auto complete
        }),
        created() {
            this.unwatch1 = this.$store.watch(
                (state, getters) => getters.product_sku,
                (newValue, oldValue) => {
                    this.querySelections(newValue);
                    this.searchProductSku = newValue;
                    this.selectProductSku = newValue;
                },
            );
            this.unwatch2 = this.$store.watch(
                (state, getters) => getters.item_spe,
                (newValue, oldValue) => {
                    this.searchValue = newValue
                },
            );
        },
        watch: {
            searchProductSku (val) {
                val && val !== this.selectProductSku && this.querySelections(val)
            },
        },
        methods: {
            ...mapActions([ "searchItem", "searchItemByItemSpe","resetVoucherForm","renewItemsArray", "changeDrawerSideBar"]),
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
            textFieldChange() {
                if(this.searchValue.length == 0) this.renewItemsArray();

                if(this.searchValue.length == 5){
                //regular expression test for "15gr02157"
                //-- const regex = /(^(0[5-9]|1[0-6]))([a-z]{2})[0-9][0-9](0[0-9]|1[0-5])[0-7]$/g;

                //regular expression test for "02157"
                const regex = /[0-9][0-9](0[0-9]|1[0-5])[0-7]$/g;
                const matches = regex.exec(this.searchValue);
                if( matches == null){
                    Swal.fire(
                        '',
                        'Sku format is something wrong',
                        'error'
                    )
                    return;
                }
                this.searchItemByItemSpe(this.searchValue);
                this.resetVoucherForm();
                }

            },
            onChange() {
                let data = { product_sku: this.selectProductSku}
                this.searchItem(data);
                // this.resetVoucherForm();
                this.searchValue = "";
            },

        },
        computed: {
            ...mapGetters(['product_sku', 'item_spe','toast_message','toast_icon']),
        },
        beforeDestroy() {
            this.unwatch1();
            this.unwatch2();
        },
    }
</script>
<style>
